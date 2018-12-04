<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Form;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */

    public function boot()
    {
        Form::component('bsText', 'components.form.text', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsTextRequired', 'components.form.text_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsDateRequired', 'components.form.date_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsEmail', 'components.form.email', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsEmailRequired', 'components.form.email_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsTel', 'components.form.tel', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsTelRequired', 'components.form.tel_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsTextarea', 'components.form.textarea', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsTextareaRequired', 'components.form.textarea_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsCkeditor', 'components.form.ckeditor', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsCkeditorRequired', 'components.form.ckeditor_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsPassword', 'components.form.password', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsPasswordRequired', 'components.form.password_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsFile', 'components.form.file', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
        Form::component('bsFileRequired', 'components.form.file_required', ['name', 'label', 'value'=>null, 'attributes'=>[]]);
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
