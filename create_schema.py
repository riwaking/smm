#!/usr/bin/env python3
import re
import os

conn_str = os.getenv('DATABASE_URL')

tables = """
CREATE TABLE IF NOT EXISTS admins (
    admin_id SERIAL PRIMARY KEY,
    admin_type VARCHAR(10) NOT NULL DEFAULT '2',
    admin_name VARCHAR(255),
    admin_email TEXT,
    username VARCHAR(225),
    password TEXT NOT NULL,
    telephone VARCHAR(50),
    register_date TIMESTAMP NOT NULL DEFAULT NOW(),
    login_date TIMESTAMP,
    login_ip VARCHAR(225),
    client_type VARCHAR(10) NOT NULL DEFAULT '2',
    access TEXT NOT NULL DEFAULT '{}',
    mode VARCHAR(225) NOT NULL DEFAULT '',
    two_factor VARCHAR(10) NOT NULL DEFAULT '0',
    two_factor_secret_key VARCHAR(100)
);

CREATE TABLE IF NOT EXISTS admin_constants (
    id SERIAL PRIMARY KEY,
    brand_logo VARCHAR(255),
    paidRent SMALLINT DEFAULT 0
);

CREATE TABLE IF NOT EXISTS article (
    id SERIAL PRIMARY KEY,
    title VARCHAR(128) NOT NULL,
    content TEXT NOT NULL,
    published_at TIMESTAMP,
    image_file VARCHAR(200)
);

CREATE TABLE IF NOT EXISTS bank_accounts (
    id SERIAL PRIMARY KEY,
    bank_name VARCHAR(225) NOT NULL,
    bank_sube VARCHAR(225) NOT NULL,
    bank_hesap VARCHAR(225) NOT NULL,
    bank_iban TEXT NOT NULL,
    bank_alici VARCHAR(225) NOT NULL
);

CREATE TABLE IF NOT EXISTS blogs (
    id SERIAL PRIMARY KEY,
    title VARCHAR(128) NOT NULL,
    content TEXT NOT NULL,
    published_at TIMESTAMP NOT NULL DEFAULT NOW(),
    image_file VARCHAR(200),
    status VARCHAR(10) NOT NULL DEFAULT '1',
    blog_get VARCHAR(225) NOT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS bulkedit (
    id SERIAL PRIMARY KEY,
    service_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS categories (
    category_id SERIAL PRIMARY KEY,
    category_name TEXT NOT NULL,
    category_name_lang TEXT,
    category_line DOUBLE PRECISION NOT NULL,
    category_type VARCHAR(10) NOT NULL DEFAULT '2',
    category_secret VARCHAR(10) NOT NULL DEFAULT '2',
    category_icon TEXT NOT NULL,
    is_refill VARCHAR(10) NOT NULL DEFAULT '1',
    category_deleted VARCHAR(10) NOT NULL DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS childpanels (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    domain VARCHAR(191) NOT NULL,
    child_panel_currency VARCHAR(191) NOT NULL,
    child_panel_username VARCHAR(191) NOT NULL,
    child_panel_password VARCHAR(191) NOT NULL,
    charged_amount REAL NOT NULL,
    child_panel_status VARCHAR(20) NOT NULL DEFAULT 'Pending',
    renewal_date DATE NOT NULL DEFAULT CURRENT_DATE,
    created_on TIMESTAMP NOT NULL DEFAULT NOW(),
    child_panel_uqid VARCHAR(225) NOT NULL
);

CREATE TABLE IF NOT EXISTS clients (
    client_id SERIAL PRIMARY KEY,
    name VARCHAR(225),
    email VARCHAR(225) NOT NULL,
    username VARCHAR(225),
    admin_type VARCHAR(10) NOT NULL DEFAULT '2',
    password TEXT NOT NULL,
    telephone VARCHAR(225),
    balance DECIMAL(21,4) NOT NULL DEFAULT 0.0000,
    spent DECIMAL(21,4) NOT NULL DEFAULT 0.0000,
    balance_type VARCHAR(10) NOT NULL DEFAULT '2',
    debit_limit DOUBLE PRECISION,
    register_date TIMESTAMP NOT NULL DEFAULT NOW(),
    login_date TIMESTAMP,
    login_ip VARCHAR(225),
    apikey TEXT NOT NULL DEFAULT '',
    tel_type VARCHAR(10) NOT NULL DEFAULT '1',
    email_type VARCHAR(10) NOT NULL DEFAULT '1',
    client_type VARCHAR(10) NOT NULL DEFAULT '2',
    access TEXT,
    lang VARCHAR(255) NOT NULL DEFAULT 'tr',
    timezone DOUBLE PRECISION NOT NULL DEFAULT 0,
    currency_type VARCHAR(10),
    ref_code TEXT NOT NULL DEFAULT '',
    ref_by TEXT,
    change_email VARCHAR(10) NOT NULL DEFAULT '2',
    resend_max INTEGER NOT NULL DEFAULT 3,
    currency VARCHAR(225) NOT NULL DEFAULT '1',
    passwordreset_token VARCHAR(225) NOT NULL DEFAULT '',
    discount_percentage INTEGER NOT NULL DEFAULT 0,
    broadcast_id VARCHAR(255) NOT NULL DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS clients_category (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    category_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS clients_price (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    service_id INTEGER NOT NULL,
    service_price DOUBLE PRECISION NOT NULL
);

CREATE TABLE IF NOT EXISTS clients_service (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    service_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS client_report (
    id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    action TEXT NOT NULL,
    report_ip VARCHAR(225) NOT NULL,
    report_date TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS currencies (
    id SERIAL PRIMARY KEY,
    currency_name VARCHAR(50) NOT NULL,
    currency_code VARCHAR(10) NOT NULL,
    currency_symbol VARCHAR(10),
    symbol_position VARCHAR(10) DEFAULT 'left',
    currency_rate DOUBLE PRECISION NOT NULL,
    currency_inverse_rate DOUBLE PRECISION NOT NULL,
    is_enable SMALLINT NOT NULL DEFAULT 0,
    currency_hash TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS custom_settings (
    id SERIAL PRIMARY KEY,
    snow_data TEXT NOT NULL DEFAULT '',
    snow_data_array TEXT NOT NULL DEFAULT '',
    snow_status VARCHAR(10) NOT NULL DEFAULT '1',
    start_count_parser TEXT NOT NULL DEFAULT '',
    orders_count_increase VARCHAR(225) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS decoration (
    id SERIAL PRIMARY KEY,
    snow_effect INTEGER NOT NULL DEFAULT 0,
    snow_colour TEXT NOT NULL DEFAULT '',
    diwali_lights INTEGER NOT NULL DEFAULT 0,
    video_link TEXT NOT NULL DEFAULT '',
    christmas_deco VARCHAR(5000) NOT NULL DEFAULT '',
    action_link TEXT NOT NULL DEFAULT '',
    pop_noti INTEGER NOT NULL DEFAULT 0,
    pop_title TEXT NOT NULL DEFAULT '',
    pop_desc TEXT NOT NULL DEFAULT '',
    action_text VARCHAR(10) NOT NULL DEFAULT '',
    action_button INTEGER NOT NULL DEFAULT 0,
    snow_fall VARCHAR(500),
    garlands TEXT,
    fire_works TEXT,
    toys TEXT,
    snowflakes INTEGER NOT NULL DEFAULT 0,
    snow_speed INTEGER NOT NULL DEFAULT 0,
    gar_shape TEXT NOT NULL DEFAULT '',
    gar_style TEXT NOT NULL DEFAULT '',
    fire_size VARCHAR(100) NOT NULL DEFAULT '',
    fire_speed TEXT NOT NULL DEFAULT '',
    toy_size INTEGER NOT NULL DEFAULT 0,
    toy_quantity INTEGER NOT NULL DEFAULT 0,
    toy_speed INTEGER NOT NULL DEFAULT 0,
    toy_launch VARCHAR(100) NOT NULL DEFAULT '',
    toy_a VARCHAR(50) NOT NULL DEFAULT '',
    toy_b VARCHAR(50) NOT NULL DEFAULT '',
    toy_c VARCHAR(50) NOT NULL DEFAULT '',
    toy_d VARCHAR(50) NOT NULL DEFAULT '',
    toy_e VARCHAR(50) NOT NULL DEFAULT '',
    toy_f VARCHAR(50) NOT NULL DEFAULT '',
    toy_g VARCHAR(50) NOT NULL DEFAULT '',
    toy_h VARCHAR(50) NOT NULL DEFAULT '',
    toy_i VARCHAR(50) NOT NULL DEFAULT '',
    toy_j VARCHAR(50) NOT NULL DEFAULT '',
    toy_k VARCHAR(50) NOT NULL DEFAULT '',
    psw_license TEXT NOT NULL DEFAULT '',
    toy_l VARCHAR(50) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS earn (
    earn_id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    link TEXT NOT NULL,
    earn_note TEXT NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'Pending'
);

CREATE TABLE IF NOT EXISTS files (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    link TEXT,
    date TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS "General_options" (
    id SERIAL PRIMARY KEY,
    coupon_status VARCHAR(10) NOT NULL DEFAULT '1',
    updates_show VARCHAR(10) NOT NULL DEFAULT '1',
    panel_status VARCHAR(20) NOT NULL DEFAULT 'Active',
    panel_orders INTEGER NOT NULL DEFAULT 0,
    panel_thismonthorders INTEGER NOT NULL DEFAULT 0,
    massorder VARCHAR(10) NOT NULL DEFAULT '2',
    balance_format VARCHAR(20) NOT NULL DEFAULT '0.0',
    currency_format VARCHAR(10) NOT NULL DEFAULT '3',
    ticket_system VARCHAR(10) NOT NULL DEFAULT '1'
);

CREATE TABLE IF NOT EXISTS integrations (
    id SERIAL PRIMARY KEY,
    name VARCHAR(225) NOT NULL,
    description VARCHAR(225) NOT NULL,
    icon_url VARCHAR(225) NOT NULL,
    code TEXT NOT NULL DEFAULT '',
    visibility INTEGER NOT NULL DEFAULT 0,
    status INTEGER NOT NULL DEFAULT 1
);

CREATE TABLE IF NOT EXISTS kuponlar (
    id SERIAL PRIMARY KEY,
    kuponadi VARCHAR(255) NOT NULL,
    adet INTEGER NOT NULL,
    tutar DOUBLE PRECISION NOT NULL
);

CREATE TABLE IF NOT EXISTS kupon_kullananlar (
    id SERIAL PRIMARY KEY,
    uye_id INTEGER NOT NULL,
    kuponadi VARCHAR(255) NOT NULL,
    tutar DOUBLE PRECISION NOT NULL
);

CREATE TABLE IF NOT EXISTS languages (
    id SERIAL PRIMARY KEY,
    language_name VARCHAR(225) NOT NULL,
    language_code VARCHAR(225) NOT NULL,
    language_type VARCHAR(10) NOT NULL DEFAULT '2',
    default_language VARCHAR(10) NOT NULL DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS "Mailforms" (
    id SERIAL PRIMARY KEY,
    subject VARCHAR(225) NOT NULL,
    message VARCHAR(225) NOT NULL,
    status VARCHAR(10) NOT NULL DEFAULT '1',
    header VARCHAR(225) NOT NULL DEFAULT '',
    footer VARCHAR(225) NOT NULL DEFAULT '',
    type VARCHAR(20) NOT NULL DEFAULT 'Users'
);

CREATE TABLE IF NOT EXISTS menus (
    id SERIAL PRIMARY KEY,
    name TEXT NOT NULL,
    menu_name_lang TEXT,
    menu_line DOUBLE PRECISION NOT NULL,
    type VARCHAR(10) NOT NULL DEFAULT '2',
    slug VARCHAR(225) NOT NULL DEFAULT '2',
    icon VARCHAR(225),
    menu_status VARCHAR(10) NOT NULL DEFAULT '1',
    visible VARCHAR(20) NOT NULL DEFAULT 'Internal',
    active VARCHAR(225) NOT NULL DEFAULT '',
    tiptext VARCHAR(225) NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS news (
    id SERIAL PRIMARY KEY,
    news_icon VARCHAR(225) NOT NULL,
    news_title VARCHAR(225) NOT NULL,
    news_title_lang TEXT,
    news_content VARCHAR(225) NOT NULL,
    news_content_lang TEXT,
    news_date TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS notifications_popup (
    id SERIAL PRIMARY KEY,
    title TEXT NOT NULL,
    type TEXT,
    action_link TEXT,
    isAllUser VARCHAR(10) NOT NULL DEFAULT '0',
    expiry_date DATE NOT NULL DEFAULT CURRENT_DATE,
    status VARCHAR(10) NOT NULL DEFAULT '1',
    description TEXT,
    action_text TEXT
);

CREATE TABLE IF NOT EXISTS orders (
    order_id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    service_id INTEGER NOT NULL,
    api_orderid INTEGER NOT NULL DEFAULT 0,
    order_error TEXT NOT NULL DEFAULT '',
    order_detail TEXT,
    order_api INTEGER NOT NULL DEFAULT 0,
    api_serviceid INTEGER NOT NULL DEFAULT 0,
    api_charge DOUBLE PRECISION NOT NULL DEFAULT 0,
    api_currencycharge DOUBLE PRECISION DEFAULT 1,
    order_profit DOUBLE PRECISION NOT NULL DEFAULT 0,
    order_quantity DOUBLE PRECISION NOT NULL DEFAULT 0,
    order_extras TEXT NOT NULL DEFAULT '',
    order_charge DOUBLE PRECISION NOT NULL DEFAULT 0,
    dripfeed VARCHAR(10) DEFAULT '1',
    dripfeed_id DOUBLE PRECISION NOT NULL DEFAULT 0,
    subscriptions_id DOUBLE PRECISION NOT NULL DEFAULT 0,
    subscriptions_type VARCHAR(10) NOT NULL DEFAULT '1',
    dripfeed_totalcharges DOUBLE PRECISION,
    dripfeed_runs DOUBLE PRECISION,
    dripfeed_delivery DOUBLE PRECISION NOT NULL DEFAULT 0,
    dripfeed_interval DOUBLE PRECISION,
    dripfeed_totalquantity DOUBLE PRECISION,
    dripfeed_status VARCHAR(20) NOT NULL DEFAULT 'active',
    order_url TEXT NOT NULL DEFAULT '',
    order_start DOUBLE PRECISION NOT NULL DEFAULT 0,
    order_finish DOUBLE PRECISION NOT NULL DEFAULT 0,
    order_remains DOUBLE PRECISION NOT NULL DEFAULT 0,
    order_create TIMESTAMP NOT NULL DEFAULT NOW(),
    order_status VARCHAR(20) NOT NULL DEFAULT 'pending',
    subscriptions_status VARCHAR(20) NOT NULL DEFAULT 'active',
    subscriptions_username TEXT,
    subscriptions_posts DOUBLE PRECISION,
    subscriptions_delivery DOUBLE PRECISION NOT NULL DEFAULT 0,
    subscriptions_delay DOUBLE PRECISION,
    subscriptions_min DOUBLE PRECISION,
    subscriptions_max DOUBLE PRECISION,
    subscriptions_expiry DATE,
    last_check TIMESTAMP NOT NULL DEFAULT NOW(),
    order_where VARCHAR(10) NOT NULL DEFAULT 'site',
    refill_status VARCHAR(20) NOT NULL DEFAULT 'Pending',
    is_refill VARCHAR(10) NOT NULL DEFAULT '1',
    refill VARCHAR(225) NOT NULL DEFAULT '1',
    cancelbutton VARCHAR(10) NOT NULL DEFAULT '1',
    show_refill VARCHAR(10) NOT NULL DEFAULT 'true',
    api_refillid DOUBLE PRECISION NOT NULL DEFAULT 0,
    avg_done VARCHAR(10) NOT NULL DEFAULT '1',
    order_increase INTEGER NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS pages (
    page_id SERIAL PRIMARY KEY,
    page_name VARCHAR(225) NOT NULL,
    page_get VARCHAR(225) NOT NULL,
    page_content TEXT NOT NULL DEFAULT '',
    page_status VARCHAR(10) NOT NULL DEFAULT '1',
    active VARCHAR(10) NOT NULL DEFAULT '1',
    seo_title VARCHAR(225) NOT NULL DEFAULT '',
    seo_keywords VARCHAR(225) NOT NULL DEFAULT '',
    seo_description VARCHAR(225) NOT NULL DEFAULT '',
    last_modified TIMESTAMP NOT NULL DEFAULT NOW(),
    del VARCHAR(255) NOT NULL DEFAULT '1',
    page_content2 TEXT NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS panel_categories (
    id SERIAL PRIMARY KEY,
    name TEXT,
    status VARCHAR(10) NOT NULL DEFAULT '1'
);

CREATE TABLE IF NOT EXISTS panel_info (
    panel_id SERIAL PRIMARY KEY,
    panel_domain TEXT NOT NULL,
    panel_plan TEXT NOT NULL,
    panel_status VARCHAR(20) NOT NULL DEFAULT 'Active',
    panel_orders INTEGER NOT NULL DEFAULT 0,
    panel_thismonthorders INTEGER NOT NULL DEFAULT 0,
    date_created TIMESTAMP NOT NULL DEFAULT NOW(),
    api_key VARCHAR(225) NOT NULL DEFAULT '',
    renewal_date TIMESTAMP NOT NULL DEFAULT NOW(),
    panel_type VARCHAR(10) NOT NULL DEFAULT 'Main'
);

CREATE TABLE IF NOT EXISTS paymentmethods (
    methodId SERIAL PRIMARY KEY,
    methodName VARCHAR(300),
    methodLogo VARCHAR(200),
    methodVisibleName VARCHAR(300),
    methodCallback VARCHAR(100),
    methodMin INTEGER NOT NULL DEFAULT 1,
    methodMax INTEGER NOT NULL DEFAULT 1,
    methodFee REAL NOT NULL DEFAULT 0,
    methodBonusPercentage REAL NOT NULL DEFAULT 0,
    methodBonusStartAmount INTEGER NOT NULL DEFAULT 0,
    methodCurrency VARCHAR(3),
    methodStatus VARCHAR(10) NOT NULL DEFAULT '0',
    methodExtras TEXT,
    methodPosition INTEGER,
    methodInstructions TEXT
);

CREATE TABLE IF NOT EXISTS payments (
    payment_id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    client_balance DECIMAL(15,2) NOT NULL DEFAULT 0.00,
    payment_amount DECIMAL(15,4) NOT NULL,
    payment_privatecode DOUBLE PRECISION,
    payment_method INTEGER NOT NULL,
    payment_status VARCHAR(10) NOT NULL DEFAULT '1',
    payment_delivery VARCHAR(10) NOT NULL DEFAULT '1',
    payment_note VARCHAR(255) NOT NULL DEFAULT 'No',
    payment_mode VARCHAR(20) NOT NULL DEFAULT 'Automatic',
    payment_create_date TIMESTAMP NOT NULL DEFAULT NOW(),
    payment_update_date TIMESTAMP NOT NULL DEFAULT NOW(),
    payment_ip VARCHAR(225) NOT NULL DEFAULT '',
    payment_extra TEXT NOT NULL DEFAULT '',
    payment_bank INTEGER NOT NULL DEFAULT 0,
    t_id VARCHAR(255)
);

CREATE TABLE IF NOT EXISTS referral (
    referral_id SERIAL PRIMARY KEY,
    referral_client_id INTEGER NOT NULL,
    referral_clicks DOUBLE PRECISION NOT NULL DEFAULT 0,
    referral_sign_up DOUBLE PRECISION NOT NULL DEFAULT 0,
    referral_totalFunds_byReffered DOUBLE PRECISION NOT NULL DEFAULT 0,
    referral_earned_commision DOUBLE PRECISION DEFAULT 0,
    referral_requested_commision VARCHAR(225) DEFAULT '0',
    referral_total_commision DOUBLE PRECISION DEFAULT 0,
    referral_status VARCHAR(10) NOT NULL DEFAULT '1',
    referral_code TEXT NOT NULL,
    referral_rejected_commision DOUBLE PRECISION NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS referral_payouts (
    r_p_id SERIAL PRIMARY KEY,
    r_p_code TEXT NOT NULL,
    r_p_status VARCHAR(10) NOT NULL DEFAULT '0',
    r_p_amount_requested DOUBLE PRECISION NOT NULL,
    r_p_requested_at TIMESTAMP NOT NULL DEFAULT NOW(),
    r_p_updated_at TIMESTAMP NOT NULL DEFAULT NOW(),
    client_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS serviceapi_alert (
    id SERIAL PRIMARY KEY,
    service_id INTEGER NOT NULL,
    serviceapi_alert TEXT NOT NULL,
    servicealert_extra TEXT NOT NULL,
    servicealert_date TIMESTAMP NOT NULL DEFAULT NOW()
);

CREATE TABLE IF NOT EXISTS services (
    service_id SERIAL PRIMARY KEY,
    service_api INTEGER NOT NULL DEFAULT 0,
    api_service INTEGER NOT NULL DEFAULT 0,
    api_servicetype VARCHAR(10) NOT NULL DEFAULT '2',
    api_detail TEXT NOT NULL DEFAULT '',
    category_id INTEGER NOT NULL,
    service_line DOUBLE PRECISION NOT NULL,
    service_type VARCHAR(10) NOT NULL DEFAULT '2',
    service_package VARCHAR(20) NOT NULL DEFAULT '1',
    service_name TEXT NOT NULL,
    service_description TEXT,
    service_price VARCHAR(225) NOT NULL,
    service_min DOUBLE PRECISION NOT NULL,
    service_max DOUBLE PRECISION NOT NULL,
    service_dripfeed VARCHAR(10) NOT NULL DEFAULT '1',
    service_autotime DOUBLE PRECISION NOT NULL DEFAULT 0,
    avg_time VARCHAR(225),
    subscriptions VARCHAR(10) NOT NULL DEFAULT '1',
    service_refill VARCHAR(225) NOT NULL DEFAULT '0',
    neworder_detail TEXT,
    service_deleted VARCHAR(10) NOT NULL DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS service_api (
    id SERIAL PRIMARY KEY,
    api_name VARCHAR(225) NOT NULL,
    api_link TEXT NOT NULL,
    api_key TEXT NOT NULL,
    api_status VARCHAR(10) NOT NULL DEFAULT '1',
    api_balance DOUBLE PRECISION,
    api_currency VARCHAR(10),
    api_priceconvert DOUBLE PRECISION NOT NULL DEFAULT 1,
    api_type VARCHAR(10) NOT NULL DEFAULT '1'
);

CREATE TABLE IF NOT EXISTS settings (
    id SERIAL PRIMARY KEY,
    site_seo TEXT NOT NULL DEFAULT '',
    site_title TEXT NOT NULL DEFAULT '',
    site_description TEXT NOT NULL DEFAULT '',
    site_keywords TEXT NOT NULL DEFAULT '',
    site_logo TEXT NOT NULL DEFAULT '',
    site_name TEXT NOT NULL DEFAULT '',
    site_currency TEXT NOT NULL DEFAULT '',
    site_base_currency VARCHAR(10) NOT NULL DEFAULT 'INR',
    site_currency_converter INTEGER NOT NULL DEFAULT 1,
    site_update_rates_automatically INTEGER NOT NULL DEFAULT 1,
    last_updated_currency_rates TIMESTAMP,
    favicon TEXT NOT NULL DEFAULT '',
    site_language VARCHAR(10) NOT NULL DEFAULT 'en',
    site_theme VARCHAR(50) NOT NULL DEFAULT 'modified',
    site_theme_alt VARCHAR(50) NOT NULL DEFAULT 'pink',
    recaptcha VARCHAR(10) NOT NULL DEFAULT '1',
    recaptcha_key TEXT NOT NULL DEFAULT '',
    recaptcha_secret TEXT NOT NULL DEFAULT '',
    custom_header TEXT NOT NULL DEFAULT '',
    custom_footer TEXT NOT NULL DEFAULT '',
    ticket_system VARCHAR(10) NOT NULL DEFAULT '1',
    register_page VARCHAR(10) NOT NULL DEFAULT '2',
    service_speed VARCHAR(10) NOT NULL DEFAULT '1',
    service_list VARCHAR(10) NOT NULL DEFAULT '2',
    dolar_charge DOUBLE PRECISION NOT NULL DEFAULT 0,
    euro_charge DOUBLE PRECISION NOT NULL DEFAULT 0,
    smtp_user TEXT NOT NULL DEFAULT '',
    smtp_pass TEXT NOT NULL DEFAULT '',
    smtp_server TEXT NOT NULL DEFAULT '',
    smtp_port TEXT NOT NULL DEFAULT '',
    smtp_protocol VARCHAR(10) NOT NULL DEFAULT '0',
    alert_type VARCHAR(10) NOT NULL DEFAULT '2',
    alert_apimail VARCHAR(10) NOT NULL DEFAULT '2',
    alert_newmanuelservice VARCHAR(10) NOT NULL DEFAULT '2',
    alert_newticket VARCHAR(10) NOT NULL DEFAULT '2',
    alert_apibalance VARCHAR(10) NOT NULL DEFAULT '2',
    alert_serviceapialert VARCHAR(10) NOT NULL DEFAULT '2',
    sms_provider VARCHAR(50) NOT NULL DEFAULT 'bizimsms',
    sms_title TEXT NOT NULL DEFAULT '',
    sms_user TEXT NOT NULL DEFAULT '',
    sms_pass TEXT NOT NULL DEFAULT '',
    sms_validate VARCHAR(10) NOT NULL DEFAULT '1',
    admin_mail TEXT NOT NULL DEFAULT '',
    admin_telephone TEXT NOT NULL DEFAULT '',
    resetpass_page VARCHAR(10) NOT NULL DEFAULT '2',
    resetpass_sms VARCHAR(10) NOT NULL DEFAULT '1',
    resetpass_email VARCHAR(10) NOT NULL DEFAULT '2',
    site_maintenance VARCHAR(10) NOT NULL DEFAULT '2',
    servis_siralama VARCHAR(10) NOT NULL DEFAULT 'asc',
    bronz_statu INTEGER NOT NULL DEFAULT 500,
    silver_statu INTEGER NOT NULL DEFAULT 2500,
    gold_statu INTEGER NOT NULL DEFAULT 10000,
    bayi_statu INTEGER NOT NULL DEFAULT 15000,
    child_panel_nameservers TEXT NOT NULL DEFAULT '{}',
    childpanel_price INTEGER NOT NULL DEFAULT 100,
    snow_effect TEXT NOT NULL DEFAULT '',
    snow_colour TEXT NOT NULL DEFAULT '',
    promotion VARCHAR(10) NOT NULL DEFAULT '2',
    referral_commision INTEGER NOT NULL DEFAULT 10,
    referral_payout INTEGER NOT NULL DEFAULT 10,
    referral_status VARCHAR(10) NOT NULL DEFAULT '2',
    childpanel_selling VARCHAR(10) NOT NULL DEFAULT '2',
    tickets_per_user BIGINT NOT NULL DEFAULT 9999999999,
    name_fileds VARCHAR(10) NOT NULL DEFAULT '2',
    skype_feilds VARCHAR(10) NOT NULL DEFAULT '2',
    otp_login VARCHAR(10) NOT NULL DEFAULT '0',
    auto_deactivate_payment VARCHAR(10) NOT NULL DEFAULT '1',
    service_avg_time VARCHAR(10) NOT NULL DEFAULT '1',
    alert_orderfail VARCHAR(10) NOT NULL DEFAULT '2',
    alert_welcomemail VARCHAR(10) NOT NULL DEFAULT '2',
    freebalance VARCHAR(10) NOT NULL DEFAULT '1',
    freeamount INTEGER NOT NULL DEFAULT 2,
    alert_newmessage VARCHAR(10) NOT NULL DEFAULT '2',
    email_confirmation VARCHAR(10) NOT NULL DEFAULT '2',
    resend_max INTEGER NOT NULL DEFAULT 2,
    status VARCHAR(10) NOT NULL DEFAULT '0',
    fundstransfer_fees VARCHAR(10) NOT NULL DEFAULT '3',
    permissions TEXT NOT NULL DEFAULT '{}',
    fake_order_service_enabled VARCHAR(10) NOT NULL DEFAULT '',
    fake_order_min INTEGER NOT NULL DEFAULT 0,
    fake_order_max INTEGER NOT NULL DEFAULT 0,
    panel_orders INTEGER NOT NULL DEFAULT 0,
    panel_orders_pattern TEXT NOT NULL DEFAULT '',
    downloaded_category_icons TEXT NOT NULL DEFAULT '',
    summary_card_background_color TEXT NOT NULL DEFAULT '',
    google_login TEXT NOT NULL DEFAULT '',
    services_average_time TEXT NOT NULL DEFAULT ''
);

CREATE TABLE IF NOT EXISTS sync_logs (
    id SERIAL PRIMARY KEY,
    service_id INTEGER NOT NULL,
    action VARCHAR(225) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT NOW(),
    description VARCHAR(225) NOT NULL,
    api_id INTEGER NOT NULL
);

CREATE TABLE IF NOT EXISTS tasks (
    task_id SERIAL PRIMARY KEY,
    client_id INTEGER,
    order_id INTEGER,
    service_id INTEGER,
    task_api INTEGER,
    task_type VARCHAR(225),
    task_status VARCHAR(225) DEFAULT 'pending',
    task_response TEXT,
    task_created_at TIMESTAMP,
    task_updated_at TIMESTAMP,
    task_by TEXT,
    check_refill_status INTEGER,
    refill_orderid VARCHAR(225)
);

CREATE TABLE IF NOT EXISTS themes (
    id SERIAL PRIMARY KEY,
    theme_name TEXT NOT NULL,
    theme_dirname TEXT NOT NULL,
    theme_extras TEXT NOT NULL DEFAULT '',
    last_modified TIMESTAMP NOT NULL DEFAULT NOW(),
    newpage TEXT NOT NULL DEFAULT '',
    colour VARCHAR(10) NOT NULL DEFAULT '1'
);

CREATE TABLE IF NOT EXISTS tickets (
    ticket_id SERIAL PRIMARY KEY,
    client_id INTEGER NOT NULL,
    subject VARCHAR(225) NOT NULL,
    time TIMESTAMP NOT NULL DEFAULT NOW(),
    lastupdate_time TIMESTAMP NOT NULL DEFAULT NOW(),
    client_new VARCHAR(10) NOT NULL DEFAULT '2',
    status VARCHAR(20) NOT NULL DEFAULT 'pending',
    support_new VARCHAR(10) NOT NULL DEFAULT '1',
    canmessage VARCHAR(10) NOT NULL DEFAULT '2'
);

CREATE TABLE IF NOT EXISTS ticket_reply (
    id SERIAL PRIMARY KEY,
    ticket_id INTEGER NOT NULL,
    client_id INTEGER NOT NULL,
    time TIMESTAMP NOT NULL DEFAULT NOW(),
    support VARCHAR(10) NOT NULL DEFAULT '1',
    message TEXT NOT NULL,
    readed VARCHAR(10) NOT NULL DEFAULT '1'
);

CREATE TABLE IF NOT EXISTS ticket_subjects (
    subject_id SERIAL PRIMARY KEY,
    subject VARCHAR(225) NOT NULL,
    content TEXT,
    auto_reply VARCHAR(10) NOT NULL DEFAULT '0'
);

CREATE TABLE IF NOT EXISTS units_per_page (
    id SERIAL PRIMARY KEY,
    unit INTEGER NOT NULL,
    page TEXT NOT NULL
);

CREATE TABLE IF NOT EXISTS updates (
    u_id SERIAL PRIMARY KEY,
    service_id INTEGER NOT NULL,
    action VARCHAR(225) NOT NULL,
    date TIMESTAMP NOT NULL DEFAULT NOW(),
    description VARCHAR(225) NOT NULL DEFAULT 'Not enough data'
);

-- Insert required initial data
INSERT INTO settings (id, site_theme) VALUES (1, 'modified') ON CONFLICT (id) DO NOTHING;
INSERT INTO "General_options" (id, panel_status) VALUES (1, 'Active') ON CONFLICT (id) DO NOTHING;
INSERT INTO decoration (id) VALUES (1) ON CONFLICT (id) DO NOTHING;
INSERT INTO panel_info (panel_id, panel_domain, panel_plan, panel_status) VALUES (1, 'localhost', 'A', 'Active') ON CONFLICT (panel_id) DO NOTHING;
INSERT INTO languages (id, language_name, language_code, default_language) VALUES (1, 'English', 'en', '1') ON CONFLICT (id) DO NOTHING;
INSERT INTO admins (admin_id, admin_type, admin_name, admin_email, username, password, access, mode) VALUES (1, '3', 'Admin', 'admin@admin.com', 'admin', '1234567890', '{"admin_access":1}', 'sun') ON CONFLICT (admin_id) DO NOTHING;
INSERT INTO themes (id, theme_name, theme_dirname, colour) VALUES (5, 'Super Rental panel', 'modified', '1') ON CONFLICT (id) DO NOTHING;
INSERT INTO currencies (id, currency_name, currency_code, currency_symbol, symbol_position, currency_rate, currency_inverse_rate, is_enable, currency_hash) VALUES (1, 'Indian Rupee', 'INR', '₹', 'left', 1, 1, 1, 'a4956249500ba31bc01c4b302cfa8e1a22b8a801') ON CONFLICT (id) DO NOTHING;
"""

with open('schema.sql', 'w') as f:
    f.write(tables)

print("PostgreSQL schema file created: schema.sql")
