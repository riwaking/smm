<?php 
$pageContent = '';
$pageName = route(3) ?? 'landing';

$availablePages = [
    'landing' => 'Landing Page',
    'login' => 'Login Page', 
    'signup' => 'Signup Page',
    'services' => 'Services Page',
    'custom' => 'Custom Page'
];

$savedContent = $conn->prepare("SELECT content FROM page_builder WHERE page_name = :name");
$savedContent->execute(['name' => $pageName]);
$savedData = $savedContent->fetch(PDO::FETCH_ASSOC);
if ($savedData) {
    $pageContent = $savedData['content'];
}
?>

<div class="col-md-10">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-6">
                    <h4 style="margin: 0; color: #fff;">Visual Page Builder</h4>
                </div>
                <div class="col-md-6 text-right">
                    <select id="page-selector" class="form-control" style="display: inline-block; width: auto; margin-right: 10px;">
                        <?php foreach($availablePages as $key => $label): ?>
                            <option value="<?= $key ?>" <?= $pageName === $key ? 'selected' : '' ?>><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button id="save-page" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save Page
                    </button>
                    <a id="preview-page" href="<?= site_url('page/' . $pageName) ?>" target="_blank" class="btn btn-info">
                        <i class="fa fa-eye"></i> Preview
                    </a>
                    <button id="clear-canvas" class="btn btn-default">
                        <i class="fa fa-trash"></i> Clear
                    </button>
                </div>
            </div>
        </div>
        <div class="panel-body" style="padding: 0; background: #1a1a2e;">
            <div id="gjs" style="height: 75vh; border: none;"></div>
        </div>
    </div>
</div>

<link href="https://unpkg.com/grapesjs/dist/css/grapes.min.css" rel="stylesheet">
<link href="https://unpkg.com/grapesjs-preset-webpage/dist/grapesjs-preset-webpage.min.css" rel="stylesheet">
<style>
.gjs-one-bg { background-color: #1a1a2e !important; }
.gjs-two-color { color: #e0e0e0 !important; }
.gjs-three-bg { background-color: #16213e !important; }
.gjs-four-color, .gjs-four-color-h:hover { color: #2F86FA !important; }
.gjs-pn-btn { color: #e0e0e0 !important; }
.gjs-pn-btn.gjs-pn-active { color: #2F86FA !important; }
.gjs-block { 
    background-color: #16213e !important; 
    border: 1px solid #2a2a4a !important;
    color: #e0e0e0 !important;
}
.gjs-block:hover { border-color: #2F86FA !important; }
.gjs-category-title { background-color: #1a1a2e !important; color: #e0e0e0 !important; }
.gjs-layer-title { background-color: #16213e !important; }
.gjs-sm-sector-title { background-color: #1a1a2e !important; color: #e0e0e0 !important; }
.gjs-clm-tags { background-color: #16213e !important; }
.gjs-field { background-color: #0a0a1a !important; color: #e0e0e0 !important; border-color: #2a2a4a !important; }
.gjs-input:focus { border-color: #2F86FA !important; }
.panel-heading { background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%) !important; border-bottom: 1px solid #2F86FA !important; }
#page-selector { background-color: #16213e; color: #e0e0e0; border-color: #2a2a4a; }
</style>

<script src="https://unpkg.com/grapesjs"></script>
<script src="https://unpkg.com/grapesjs-preset-webpage"></script>
<script src="https://unpkg.com/grapesjs-blocks-basic"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    var savedContent = <?= json_encode($pageContent ?: '') ?>;
    
    var editor = grapesjs.init({
        container: '#gjs',
        fromElement: false,
        height: '75vh',
        width: 'auto',
        storageManager: false,
        plugins: ['gjs-blocks-basic', 'gjs-preset-webpage'],
        pluginsOpts: {
            'gjs-blocks-basic': {},
            'gjs-preset-webpage': {
                modalImportTitle: 'Import Template',
                modalImportLabel: '<div style="margin-bottom: 10px;">Paste your HTML/CSS here</div>',
                modalImportContent: function(editor) {
                    return editor.getHtml() + '<style>' + editor.getCss() + '</style>';
                }
            }
        },
        canvas: {
            styles: [
                'https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap',
                'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css'
            ]
        },
        blockManager: {
            appendTo: '#blocks'
        }
    });
    
    editor.BlockManager.add('section-hero', {
        label: 'Hero Section',
        category: 'Sections',
        content: `
            <section style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding: 80px 20px; text-align: center; color: #fff;">
                <h1 style="font-size: 48px; margin-bottom: 20px; color: #fff;">Welcome to Our Platform</h1>
                <p style="font-size: 20px; color: #e0e0e0; max-width: 600px; margin: 0 auto 30px;">The best SMM panel for all your social media marketing needs.</p>
                <a href="#" style="display: inline-block; background: #2F86FA; color: #fff; padding: 15px 40px; border-radius: 8px; text-decoration: none; font-weight: 600;">Get Started</a>
            </section>
        `,
        attributes: { class: 'fa fa-window-maximize' }
    });
    
    editor.BlockManager.add('section-features', {
        label: 'Features Grid',
        category: 'Sections',
        content: `
            <section style="padding: 60px 20px; background: #000;">
                <h2 style="text-align: center; color: #fff; margin-bottom: 40px;">Our Features</h2>
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; max-width: 1200px; margin: 0 auto;">
                    <div style="background: #1a1a2e; padding: 30px; border-radius: 12px; width: 300px; text-align: center; border: 1px solid #2a2a4a;">
                        <i class="fas fa-bolt" style="font-size: 40px; color: #2F86FA; margin-bottom: 15px;"></i>
                        <h3 style="color: #fff; margin-bottom: 10px;">Fast Delivery</h3>
                        <p style="color: #888;">Lightning fast order processing and delivery.</p>
                    </div>
                    <div style="background: #1a1a2e; padding: 30px; border-radius: 12px; width: 300px; text-align: center; border: 1px solid #2a2a4a;">
                        <i class="fas fa-shield-alt" style="font-size: 40px; color: #2F86FA; margin-bottom: 15px;"></i>
                        <h3 style="color: #fff; margin-bottom: 10px;">Secure</h3>
                        <p style="color: #888;">Your data is protected with enterprise security.</p>
                    </div>
                    <div style="background: #1a1a2e; padding: 30px; border-radius: 12px; width: 300px; text-align: center; border: 1px solid #2a2a4a;">
                        <i class="fas fa-headset" style="font-size: 40px; color: #2F86FA; margin-bottom: 15px;"></i>
                        <h3 style="color: #fff; margin-bottom: 10px;">24/7 Support</h3>
                        <p style="color: #888;">Our team is always here to help you.</p>
                    </div>
                </div>
            </section>
        `,
        attributes: { class: 'fa fa-th-large' }
    });
    
    editor.BlockManager.add('section-pricing', {
        label: 'Pricing Cards',
        category: 'Sections',
        content: `
            <section style="padding: 60px 20px; background: #0a0a1a;">
                <h2 style="text-align: center; color: #fff; margin-bottom: 40px;">Pricing Plans</h2>
                <div style="display: flex; flex-wrap: wrap; justify-content: center; gap: 30px; max-width: 1000px; margin: 0 auto;">
                    <div style="background: #1a1a2e; padding: 40px; border-radius: 16px; width: 280px; text-align: center; border: 1px solid #2a2a4a;">
                        <h3 style="color: #2F86FA; margin-bottom: 10px;">Starter</h3>
                        <div style="font-size: 48px; color: #fff; font-weight: 700; margin-bottom: 20px;">$9<span style="font-size: 16px; color: #888;">/mo</span></div>
                        <ul style="list-style: none; padding: 0; margin-bottom: 30px; text-align: left;">
                            <li style="color: #e0e0e0; padding: 8px 0; border-bottom: 1px solid #2a2a4a;">✓ 1000 Orders</li>
                            <li style="color: #e0e0e0; padding: 8px 0; border-bottom: 1px solid #2a2a4a;">✓ Basic Support</li>
                            <li style="color: #e0e0e0; padding: 8px 0;">✓ API Access</li>
                        </ul>
                        <a href="#" style="display: block; background: #2F86FA; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none;">Get Started</a>
                    </div>
                    <div style="background: linear-gradient(135deg, #1a1a2e 0%, #16213e 100%); padding: 40px; border-radius: 16px; width: 280px; text-align: center; border: 2px solid #2F86FA; transform: scale(1.05);">
                        <div style="background: #2F86FA; color: #fff; padding: 5px 15px; border-radius: 20px; display: inline-block; margin-bottom: 15px; font-size: 12px;">POPULAR</div>
                        <h3 style="color: #2F86FA; margin-bottom: 10px;">Pro</h3>
                        <div style="font-size: 48px; color: #fff; font-weight: 700; margin-bottom: 20px;">$29<span style="font-size: 16px; color: #888;">/mo</span></div>
                        <ul style="list-style: none; padding: 0; margin-bottom: 30px; text-align: left;">
                            <li style="color: #e0e0e0; padding: 8px 0; border-bottom: 1px solid #2a2a4a;">✓ 10000 Orders</li>
                            <li style="color: #e0e0e0; padding: 8px 0; border-bottom: 1px solid #2a2a4a;">✓ Priority Support</li>
                            <li style="color: #e0e0e0; padding: 8px 0;">✓ Full API Access</li>
                        </ul>
                        <a href="#" style="display: block; background: #2F86FA; color: #fff; padding: 12px; border-radius: 8px; text-decoration: none;">Get Started</a>
                    </div>
                </div>
            </section>
        `,
        attributes: { class: 'fa fa-dollar-sign' }
    });
    
    editor.BlockManager.add('cta-section', {
        label: 'Call to Action',
        category: 'Sections',
        content: `
            <section style="background: #2F86FA; padding: 60px 20px; text-align: center;">
                <h2 style="color: #fff; font-size: 36px; margin-bottom: 15px;">Ready to Get Started?</h2>
                <p style="color: rgba(255,255,255,0.9); font-size: 18px; margin-bottom: 30px;">Join thousands of satisfied customers today.</p>
                <a href="#" style="display: inline-block; background: #fff; color: #2F86FA; padding: 15px 40px; border-radius: 8px; text-decoration: none; font-weight: 600;">Sign Up Now</a>
            </section>
        `,
        attributes: { class: 'fa fa-bullhorn' }
    });
    
    editor.BlockManager.add('qr-payment', {
        label: 'QR Payment Box',
        category: 'Payment',
        content: `
            <div style="background: #fff; padding: 30px; border-radius: 14px; max-width: 500px; margin: 20px auto; text-align: center; box-shadow: 0 15px 40px rgba(0,0,0,0.12);">
                <h2 style="color: #0044cc; margin-bottom: 10px;">Add Funds</h2>
                <p style="color: #555; margin-bottom: 20px;">Secure payment via QR Scan</p>
                <div style="background: #f2f6ff; border-left: 5px solid #0044cc; padding: 15px; text-align: left; border-radius: 8px; margin-bottom: 25px;">
                    <p style="margin: 6px 0; color: #333;">✅ Supported: <strong>Esewa, Khalti, IME Pay</strong></p>
                    <p style="margin: 6px 0; color: #333;">💰 Minimum Deposit: <strong>200 NPR</strong></p>
                </div>
                <div style="font-weight: bold; margin-bottom: 10px; color: #222;">Scan QR Code to Pay</div>
                <div style="width: 200px; height: 200px; background: #f0f0f0; margin: 0 auto 20px; border-radius: 16px; display: flex; align-items: center; justify-content: center; box-shadow: 0 8px 25px rgba(0,0,0,0.15);">
                    <span style="color: #888;">QR Code Here</span>
                </div>
                <a href="#" style="display: inline-block; background: linear-gradient(135deg, #25D366, #1ebe5d); color: #fff; padding: 14px 30px; border-radius: 50px; text-decoration: none; font-weight: 600;">Contact on WhatsApp</a>
            </div>
        `,
        attributes: { class: 'fa fa-qrcode' }
    });
    
    if (savedContent) {
        editor.setComponents(savedContent);
    }
    
    document.getElementById('save-page').addEventListener('click', function() {
        var html = editor.getHtml();
        var css = editor.getCss();
        var fullContent = html + '<style>' + css + '</style>';
        var pageName = document.getElementById('page-selector').value;
        
        fetch('<?= site_url("admin/appearance/pagebuilder/save") ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                page_name: pageName,
                content: fullContent
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Page saved successfully!');
            } else {
                alert('Error saving page: ' + data.message);
            }
        })
        .catch(error => {
            alert('Error saving page');
            console.error(error);
        });
    });
    
    document.getElementById('clear-canvas').addEventListener('click', function() {
        if (confirm('Are you sure you want to clear the canvas?')) {
            editor.DomComponents.clear();
        }
    });
    
    document.getElementById('page-selector').addEventListener('change', function() {
        window.location.href = '<?= site_url("admin/appearance/pagebuilder") ?>/' + this.value;
    });
});
</script>
