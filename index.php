<?php
require('../../config.php');
require_once($CFG->libdir.'/moodlelib.php');

$toemail = get_config('local_messagesupport', 'toemail');

$PAGE->set_url(new moodle_url('/local/messagesupport/index.php'));
$PAGE->set_context(context_system::instance());
$PAGE->set_title(get_string('support', 'local_messagesupport')); // В названии страницы
$PAGE->set_heading(get_string('support', 'local_messagesupport')); // Сверху снаружи блока
$PAGE->requires->css(new moodle_url('/local/messagesupport/style.css'));

$alertmsg = optional_param('alertmsg', '', PARAM_TEXT);

$message = '';

echo $OUTPUT->header();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fio = required_param('fio', PARAM_TEXT);
    $email = required_param('email', PARAM_TEXT);
    $messageText = required_param('message', PARAM_TEXT);
        
    if (!empty($fio) && !empty($email) && !empty($messageText)) {
        $subject = 'Письмо с поддержки';
        $body = "ФИО: ".$fio."\nПочта: ".$email."\nПроблема:\n".$messageText;

        $send_success = email_to_user(
            (object)['email' => $toemail, 'id' => -1, 'maildisplay' => true],
            core_user::get_support_user(),
            $subject,
            $body
        );

        if ($send_success) {
            $message = 'Успешно отправлено';
        } else {
        $message = 'Возникла ошибка, попробуйте ещё раз позже';
        }

        redirect($PAGE->url, $message);
    } else {
        //echo html_writer::tag ('label', "Пожалуйста, заполните все поля");
        redirect($PAGE->url, "Пожалуйста, заполните все поля");
    }
}


echo html_writer::start_tag('form', array('method' => 'post', 'action' => $PAGE->url));
    echo html_writer::tag('label', "Опишите проблему");
    echo html_writer::tag('label', "Ваши ФИО и почта нужны, чтобы мы могли с вами связаться");
    
    echo html_writer::start_tag('div', array('class' => 'form-group'));
            
        echo html_writer::tag('input', '', array('id' => 'fio', 'name'=> 'fio', 'class' => 'input', 'placeholder' => 'Ф.И.О.'));
        echo html_writer::tag('input', '', array('id' => 'email', 'name'=> 'email', 'class' => 'input', 'placeholder' => 'Почта'));
        echo html_writer::tag('textarea', '', array('id' => 'message', 'name'=> 'message', 'class' => 'text-area'));

        echo html_writer::empty_tag('input', array('type' => 'submit', 'name' => 'submit', 'value' => 'Отправить'));
    echo html_writer::end_tag('div');

echo html_writer::end_tag('form');

echo $OUTPUT->footer();