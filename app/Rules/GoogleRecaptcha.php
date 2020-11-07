<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

use GuzzleHttp\Client;

class GoogleRecaptcha implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return $this->verify($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return ':attribute invalid';
    }

    private function verify(string $token = null) : bool
    {
        $url = 'https://www.google.com/recaptcha/api/siteverify';
        $postdata = [
            'secret' => config('app.GOOGLE_RECAPTCHA_SECRET'),
            'response' => $token,
        ];
        
        $client = new Client();
        $response = $client->request('POST', $url, [
            'form_params' => $postdata
        ]);

        $code = $response->getStatusCode();
        $content = json_decode($response->getBody()->getContents());

        if ($code === 200 && $content->success === true) {
            return true;
        }

        return false;
    }
}
