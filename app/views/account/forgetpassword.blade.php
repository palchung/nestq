

{{ Form::open([
        "route"        => "account/resetpassword",
        "autocomplete" => "off"
    ]) }}
{{ Form::label("email", "Email") }}
{{ Form::text("email", Input::get("email"), [
            "placeholder" => "Your registered email"
        ]) }}
{{ Form::submit("reset") }}
{{ Form::close() }}


