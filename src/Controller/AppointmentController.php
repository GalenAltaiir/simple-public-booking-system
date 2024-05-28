<?php

namespace App\Controller;

use App\Helpers;
use App\Model\Database;
use App\Model\Appointment;

class AppointmentController
{

    public static function index()
    {
        $appointments = Appointment::all();

        return Helpers::response()->json($appointments);
    }

    public static function create()
    {
        $data = $_POST;
        
        self::validate($data);
        
        $datetime = $data['dateStr'];
        $time = date('H:i', strtotime($datetime));
        $date = date('Y-m-d', strtotime($datetime));
        
        $newData = [
            'first_name' => $data['firstName'],
            'last_name' => $data['lastName'],
            'phone' => $data['phoneNumber'],
            'email' => $data['emailAddress'],
            'date' => $date,
            'start_time' => $time,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s'),
        ];
        
        
        $columns = implode(", ", array_keys($newData));
        $placeholders = implode(", ", array_fill(0, count($newData), "?"));
        $values = array_values($newData);

        $query = "INSERT INTO appointments ($columns) VALUES ($placeholders)";
        $stmt = Database::getInstance()->getPdo()->prepare($query);

        if ($stmt->execute($values)) {
            http_response_code(201);
            return Helpers::response()->json([
                'status' => 201,
                'appointment' => $newData,
            ]);
        } else {
            http_response_code(400);
            return Helpers::response()->json([
                'status' => 400,
                'message' => 'Failed to create appointment.',
            ]);
        }
        //return Helpers::response()->json($data);
    }

    public static function validate($data)
    {
        $requiredFields = ['firstName', 'lastName', 'emailAddress', 'phoneNumber', 'dateStr'];

        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || empty($data[$field])) {
                http_response_code(400);
                return Helpers::response()->json([
                    'status' => 400,
                    'message' => 'Some data missing.',
                ]);
            }
        }

        foreach ($data as $key => $value) {
            if (empty($value)) {
                return Helpers::response()->json([
                    'status' => 400,
                    'message' => 'Validation failed.',
                ]);
            }
        }

        self::checkIfExistsToday($data['emailAddress'], $data['phoneNumber']);

    }

    public static function checkIfExistsToday($email, $phone)
    {
        $query = "SELECT COUNT(*) FROM appointments WHERE (email = ? OR phone = ?) AND created_at >= CURDATE()";
        $stmt = Database::getInstance()->getPdo()->prepare($query);
        $stmt->execute([$email, $phone]);
        $count = $stmt->fetchColumn();

        if ($count > 0) {
            return Helpers::response()->json([
                'status' => 422,
                'message' => 'This person already booked a meeting today.',
            ]);
        }
    }

    public static function getAvailableTimes()
    {
        $availableTimes = Appointment::currentBookings();

        return Helpers::response()->json($availableTimes);
    }
}