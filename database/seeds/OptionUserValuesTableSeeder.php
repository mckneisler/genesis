<?php

use Illuminate\Database\Seeder;

use App\Models\OptionUserValue;

class OptionUserValuesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$this->command->info('Creating option user values...');

		$user = user(1);

		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.font')->id,
			'value_id' => code('fonts.comic-sans')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.label_position')->id,
			'value_id' => code('label_positions.left')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display:messages.message_timer')->id,
			'value_id' => code('durations.4000')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display:messages.show_popup_errors')->id,
			'value_id' => code('yes_no.0')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display:messages.show_popup_messages')->id,
			'value_id' => code('yes_no.0')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.round')->id,
			'value_id' => code('yes_no.0')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.shadow')->id,
			'value_id' => code('shadow_sizes.large')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.show_submenus')->id,
			'value_id' => code('yes_no.0')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.style')->id,
			'value_id' => code('styles.bootstrap')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.theme')->id,
			'value_id' => code('colors.deep-purple')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:downloads.delimiter')->id,
			'value_id' => code('delimiters.,')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:downloads.qualifier')->id,
			'value_id' => code('qualifiers."')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:localization:date_time.date_format')->id,
			'value_id' => code('date_formats.M j, Y')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:localization:date_time.time_format')->id,
			'value_id' => code('time_formats.g:i a')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:localization:date_time.timezone')->id,
			'value_id' => code('timezones.America/Chicago')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:localization.locale')->id,
			'value_id' => code('locales.en')->id
		]);

		$user = user(2);

		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.theme')->id,
			'value_id' => code('colors.orange')->id
		]);
		OptionUserValue::create([
			'user_id' => $user->id,
			'option_id' => code('options:display.round')->id,
			'value_id' => code('yes_no.1')->id
		]);
    }
}
