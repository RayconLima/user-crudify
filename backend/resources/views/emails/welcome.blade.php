@if (is_null($user->email_verified_at))
    <p>Olá {{ $user->name }},</p>
    <p>Seja bem-vindo(a) ao {{ config('app.name') }}. Por favor, verifique seu e-mail clicando no link abaixo. </p>

    <table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
        <tbody>
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                    <tr>
                        <td> <a href="{{ config('app.platform_url') }}/verificar-email?token={{ $user->token }}" target="_blank">VERIFICAR E-MAIL</a> </td>
                    </tr>
                    </tbody>
                </table>
            </td>
        </tr>
        </tbody>
    </table>

    <p>Ou, simplesmente copie e cole o link abaixo em seu navegador:</p>
    <a href="{{ config('app.platform_url') }}/verificar-email?token={{ $user->token }}">{{ config('app.platform_url') }}/verificar-email?token={{ $user->token }}</a>
@else
    <p>Olá {{ $user->name }},</p>

    <p>Sua conta já está verificada. Se você tiver alguma dúvida, entre em contato com nossa equipe de suporte.</p>

    <p>
    Atenciosamente, <br />
    A Equipe {{ config('app.name') }}
    </p>
@endif





