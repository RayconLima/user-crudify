<p>Olá {{ $user->name }},</p>
<p>Você foi convidado a se juntar à nossa plataforma. Para criar sua conta, por favor, clique no link abaixo:</p>

<table role="presentation" border="0" cellpadding="0" cellspacing="0" class="btn btn-primary">
    <tbody>
    <tr>
        <td align="center">
            <table role="presentation" border="0" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td> <a href="{{ config('app.platform_url') }}/nova-senha?token={{ $user->verification_token }}" target="_blank">NOVA SENHA</a> </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>

<p>
Atenciosamente, <br />
A Equipe {{ config('app.name') }}
</p>