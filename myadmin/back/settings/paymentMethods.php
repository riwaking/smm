<?php
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if ($_GET["action"] == "getData") {
        $paymentMethods = $conn->prepare("SELECT methodid, methodlogo, methodvisiblename, methodmin, methodmax, methodstatus FROM paymentmethods ORDER BY methodposition ASC");
        $paymentMethods->execute();
        $paymentMethods = $paymentMethods->fetchAll(PDO::FETCH_ASSOC);
        $methods = [];
        for ($i = 0; $i < count($paymentMethods); $i++) {
            $methods[] = [
                "id" => $paymentMethods[$i]["methodid"],
                "name" => $paymentMethods[$i]["methodvisiblename"],
                "logo" => $paymentMethods[$i]["methodlogo"],
                "min" => $paymentMethods[$i]["methodmin"],
                "max" => $paymentMethods[$i]["methodmax"],
                "status" => $paymentMethods[$i]["methodstatus"]
            ];
        }
        header("Content-Type: application/json");
        echo json_encode($methods);
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $manualMethods = [
        100,
        101,
        102,
        103,
        104,
        105,
        106,
        107,
        108,
        109
    ];

    if (route(3) == "getForm") {
        $methodId = intval($_POST["methodId"]);
        $response = [];
        $method = $conn->prepare("SELECT methodid, methodvisiblename, methodmin, methodmax, methodfee, methodbonuspercentage, methodbonusstartamount, methodstatus, methodextras, methodinstructions FROM paymentmethods WHERE methodid=:id");
        $method->execute([
            "id" => $methodId
        ]);

        if ($method->rowCount()) {
            $method = $method->fetch(PDO::FETCH_ASSOC);
            $methodExtras = json_decode($method["methodextras"], 1);
            require_once("paymentMethods/getForm.php");
            $response = [
                "success" => true,
                "content" => $form
            ];

            header("Content-Type: application/json");
            echo json_encode($response);

        } else {
            errorExit("This payment method doesn't exist.");
        }

    }
    if (route(3) == "edit") {
        $response = [];
        require_once("paymentMethods/edit.php");

        echo json_encode($response);
    }

    if (route(3) == "activate") {
        $update = $conn->prepare("UPDATE paymentmethods SET methodstatus=:status WHERE methodid=:id");
        $update->execute([
            "status" => 1,
            "id" => intval($_POST["methodId"])
        ]);
    }
    if (route(3) == "deactivate") {
        $update = $conn->prepare("UPDATE paymentmethods SET methodstatus=:status WHERE methodid=:id");
        $update->execute([
            "status" => 0,
            "id" => intval($_POST["methodId"])
        ]);
    }

    if (route(3) == "sort") {
        $sortData = json_decode(base64_decode($_POST["sortData"]), 1);
        for ($i = 0; $i < count($sortData); $i++) {
            $methodPos = $i + 1;
            $methodId = intval($sortData[$i]);
            $update = $conn->prepare("UPDATE paymentmethods SET methodposition=:position WHERE methodid=:id");
            $update->execute([
                "position" => $methodPos,
                "id" => $methodId
            ]);
        }
    }

    exit;
}