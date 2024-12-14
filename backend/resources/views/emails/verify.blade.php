<p>Olá {{ $user->name }},</p>
<p>Seja bem-vindo(a) ao {{ config('app.name') }}. Por favor, verifique seu e-mail clicando no link abaixo:</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
        <tr>
            <td align="center">
                <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td>
                                <a href="{{ config('app.platform_url') }}/verificar-email?token={{ $user->verification_token }}" target="_blank" style="display: inline-block; padding: 10px 20px; font-size: 16px; color: #ffffff; background-color: #007bff; text-decoration: none; border-radius: 5px;">
                                    VERIFICAR E-MAIL
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>

<p>Ou, simplesmente copie e cole o link abaixo em seu navegador:</p>
<p>
    <a href="{{ config('app.platform_url') }}/verificar-email?token={{ $user->verification_token }}">
        {{ config('app.platform_url') }}/verificar-email?token={{ $user->verification_token }}
    </a>
</p>