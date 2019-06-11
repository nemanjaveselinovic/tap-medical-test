<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class GetAppointmentsRequest extends Request
{
  /**
   * Determine if the user is authorized to make this request.
   *
   * @return bool
   */
  public function authorize()
  {
    return true;
  }

  /**
   * Get the validation rules that apply to the request.
   *
   * @return array
   */
  public function rules()
  {
    return [
      'doctor' => 'required|string|max:255',
      'appointments_date' => 'required|date_format:m/d/Y'
    ];
  }
}
