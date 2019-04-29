<?php namespace Library;

use Illuminate\Http\Response;
use Config;
use Carbon\Carbon;

class Utilities
{
    /**
     * Used to response the data
     *
     * @return JSON
     */
    public static function sendResponse($data, $httpCode){
       return (new Response($data, $httpCode))->header('Content-Type', 'application/json');
    }
      
    /**
     * Used to encrypt the string
     *
     * @param string $string
     * @return string
     */
    public static function encrypt($string) {
        $secret_key = Config::get('constants.DEFAULT_DATA.ENC_SECRET');
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        $output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
        return  base64_encode($output);
    }

    /**
     * Used to decrypt the string
     *
     * @param string $string
     * @return string
     */
    public static function decrypt($string) {
        $secret_key = Config::get('constants.DEFAULT_DATA.ENC_SECRET');
        $output = false;

        $encrypt_method = "AES-256-CBC";
        $secret_iv = 'This is my secret iv';

        // hash
        $key = hash('sha256', $secret_key);

        // iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
        $iv = substr(hash('sha256', $secret_iv), 0, 16);
        return  openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
    }

    /**
     * Used to valid the input 
     *
     * @param string $string
     * @param string $message
     * @return boolean
     */
    public static function validateText($string, &$message){
        $hasError = false;
        $message = '';

        $string = stripslashes($string);
        $string = htmlspecialchars($string);

        if (strlen(trim($string)) == 0) {
            $hasError = true;
            $message = 'Name is mandatory';
        } else if (!preg_match("/^([a-zA-Z. ]+)$/", $string)) {
            $hasError = true;
            $message = 'Name can not contain numbers, space or special characters';
        }

        return $hasError;
    }

    /**
     * Used to valid the file type input
     *
     * @param File $file
     * @param string $message
     * @return boolean
     */
    public static function validateFile($file, &$message) {
        $hasError = false;
        $message = '';
        $supportedFileextension = ['jpg', 'png', 'gif', 'JPG', 'PNG', 'GIF'];

        $fileExtension = $file->getClientOriginalExtension();
        if (!in_array($fileExtension, $supportedFileextension)) {
            $hasError = true;
            $message = 'File is invalid. It should be image.';
        }

        return $hasError;
    }

    /**
     * Used to generate a file name
     *
     * @param string $fileFor
     * @param string $fileExtension
     * @return string
     */
    public static function generateFileName($fileFor, $fileExtension = 'png')
    {
        switch ($fileFor) {
            case 'Team':
                $fileName = 't'.Carbon::now()->timestamp.'.'.$fileExtension;
                break;
            case 'Player':
                $fileName = 'p'.Carbon::now()->timestamp.'.'.$fileExtension;
                break;
            default:
                $fileName = Carbon::now()->timestamp.'.'.$fileExtension;
                break;
        }

        return $fileName;
    }

    /**
     * Used to valid if team contain invalid data i.e., numeric or not
     *
     * @param string $data
     * @param string $message
     * @return boolean
     */
    public static function checkArrayValuesAsNumeric($team, &$message)
    {
        $hasError = false;
        
        if (trim($team) != "") {
            if (!preg_match("/^([0-9,]+)$/", $team)) {
                $hasError = true;
                $message = 'Team can contain numeric value separated by comma';
            }
        }

        return $hasError;
    }
}