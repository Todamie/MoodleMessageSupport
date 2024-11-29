<?php
defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {

	$settings = new admin_settingpage(
        'local_messagesupport',
        get_string('support', 'local_messagesupport')
    );

    $settings->add(new admin_setting_configtext(
        'local_messagesupport/toemail',
        "Почта",
        "Указывается, кому отправляются письма от плагина поддержки",
        'example@mail.ru', //по умолчанию
        PARAM_EMAIL
    ));

	$ADMIN->add('localplugins', $settings);
	//ADMIN->add('grades', new admin_category('support_plugin', get_string('pluginname', 'local_messagesupport')));
	//$ADMIN->add('support_plugin', new admin_externalpage('local_messagesupport', get_string('support', 'local_messagesupport'), new moodle_url('/local/messagesupport/index.php')));
    
}
