<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class OptionRequest extends Request
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
			'options-downloads-delimiter_value_id' => 'required',
			'options-downloads-qualifier_value_id' => 'required',
			'options-localization-locale_value_id' => 'required',
			'options-localization-date_time-date_format_value_id' => 'required',
			'options-localization-date_time-time_format_value_id' => 'required',
			'options-localization-date_time-timezone_value_id' => 'required',
			'options-display-theme_value_id' => 'required',
			'options-display-font_value_id' => 'required',
			'options-display-label_position_value_id' => 'required',
			'options-display-round_value_id' => 'required',
			'options-display-shadow_value_id' => 'required',
			'options-display-show_submenus_value_id' => 'required',
			'options-display-style_value_id' => 'required',
			'options-display-messages-message_timer_value_id' => 'required',
			'options-display-messages-show_popup_errors_value_id' => 'required',
			'options-display-messages-show_popup_messages_value_id' => 'required'
		];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
			'options-downloads-delimiter_value_id' => choose(code('options:downloads.delimiter')->name, 1),
			'options-downloads-qualifier_value_id' => choose(code('options:downloads.qualifier')->name, 1),
			'options-localization-locale_value_id' => choose(code('options:localization.locale')->name, 1),
			'options-localization-date_time-date_format_value_id' => choose(code('options:localization:date_time.date_format')->name, 1),
			'options-localization-date_time-time_format_value_id' => choose(code('options:localization:date_time.time_format')->name, 1),
			'options-localization-date_time-timezone_value_id' => choose(code('options:localization:date_time.timezone')->name, 1),
			'options-display-theme_value_id' => choose(code('options:display.theme')->name, 1),
			'options-display-font_value_id' => choose(code('options:display.font')->name, 1),
			'options-display-label_position_value_id' => choose(code('options:display.label_position')->name, 1),
			'options-display-round_value_id' => choose(code('options:display.round')->name, 1),
			'options-display-shadow_value_id' => choose(code('options:display.shadow')->name, 1),
			'options-display-show_submenus_value_id' => choose(code('options:display.show_submenus')->name, 1),
			'options-display-style_value_id' => choose(code('options:display.style')->name, 1),
			'options-display-messages-message_timer_value_id' => choose(code('options:display:messages.message_timer')->name, 1),
			'options-display-messages-show_popup_errors_value_id' => choose(code('options:display:messages.show_popup_errors')->name, 1),
			'options-display-messages-show_popup_messages_value_id' => choose(code('options:display:messages.show_popup_messages')->name, 1)
		];
    }
}
