<?php
namespace App\Model;

use stdClass;
use App\Model\Database;

class Appointment
{
    public $id;
    public $name;
    public $surname;
    public $email;
    public $phone;
    public $date;
    public $time;
    public $created_at;
    public $updated_at;

    public function __construct($id, $name, $surname, $email, $phone, $date, $time, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->phone = $phone;
        $this->date = $date;
        $this->time = $time;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }

    public static function all()
    {
        $pdo = Database::getInstance()->getPdo();
        $stmt = $pdo->query('SELECT * FROM appointments');
        $appointments = [];
        while ($row = $stmt->fetch()) {
            $appointment = new stdClass();
            $appointment->id = $row['id'];
            $appointment->firstName = $row['first_name'];
            $appointment->lastName = $row['last_name'];
            $appointment->email = $row['email'];
            $appointment->phone = $row['phone'];
            $appointment->date = $row['date'];
            $appointment->startTime = $row['start_time'];
            $appointment->createdAt = $row['created_at'];
            $appointment->updatedAt = $row['updated_at'];
            $appointments[] = $appointment;
        }

        return $appointments;
    }

    public static function currentBookings()
    {
        $appointments = self::all();
        $exclusions = [];
        
        foreach ($appointments as $appointment) {
            $exclusions[] = [
            "time" => $appointment->startTime,
            "date" => $appointment->date
            ];
        }
        return $exclusions;
    }
}