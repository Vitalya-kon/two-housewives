<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormServiceController extends Controller
{
    public function submitForm(Request $request)
    {
        // Валидация и обработка данных формы...
        $select_service = '';
        foreach ($request->selectedOptions as $option) {
            $select_service .= $option . ', ';
        }
        if($request->date != '') {
            $timestamp = strtotime($request->date); // Преобразование даты в метку времени Unix
            $formattedDate = date("d.m.Y", $timestamp); // Преобразование метки времени Unix в формат dd.mm.yyyy
        }else{
            $formattedDate = 'не назначено';
        }

        // Отправка сообщения в Telegram
        $phone = '+' . preg_replace('/\D/', '', $request->phone);
        $message = "Новая заявка:\nИмя: " . $request->name . "\nТелефон: " . $phone . "\nУслуга: " . $select_service . "\nОписание: " . $request->description . "\nДата: " . $formattedDate;
        $this->sendToTelegram($message);

        // Сохранение данных формы и другие операции...
    }

    public function sendToTelegram($text)
    {
        $token = "6430603532:AAEK4TSsJBaeXZzSu2qjf13s6NfxMBPOFvE";
        $chat_id = "-4126959636";
        $url = "https://api.telegram.org/bot" . $token . "/sendMessage?chat_id=" . $chat_id;
        $url .= "&text=" . urlencode($text);

        $ch = curl_init();
        $optArray = array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true
        );
        curl_setopt_array($ch, $optArray);
        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }
}
