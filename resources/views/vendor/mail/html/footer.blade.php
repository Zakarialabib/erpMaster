<tr>
    <td>
        <table class="footer" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
            <tr>
                <td height="60" style="font-size:60px;line-height:60px;" data-height="Footer spacing top">&nbsp;</td>
            </tr>
            <tr data-element="colibri-footer-social-icons" data-label="Social Icons">
                <td align="center">
                    <!-- Social Icons -->
                    <table border="0" align="center" cellpadding="0" cellspacing="0" role="presentation"
                        width="100%" style="width:100%;max-width:100%;">
                        <tr>
                            <td align="center">
                                <table border="0" align="center" cellpadding="0" cellspacing="0"
                                    role="presentation">
                                    <tr>
                                        <td data-element="colibri-footer-facebook" data-label="Facebook"
                                            class="rwd-on-mobile" align="center" valign="middle" height="36"
                                            style="height: 36px;">
                                            <table border="0" align="center" cellpadding="0" cellspacing="0"
                                                role="presentation">
                                                <tr>
                                                    <td width="10"></td>
                                                    <td align="center">
                                                        <a href="{{ settings('social_facebook') }}" target="__blank">
                                                            <img style="width:36px;border:0px;display: inline!important;"
                                                                {{ asset('assets/img/Facebook.png') }}" width="36"
                                                                border="0" editable="true" data-icon data-image-edit
                                                                data-url data-label="Facebook" data-image-width
                                                                alt="icon">
                                                        </a>
                                                    </td>
                                                    <td width="10"></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td data-element="colibri-footer-instagram" data-label="Instagram"
                                            class="rwd-on-mobile" align="center" valign="middle" height="36"
                                            style="height: 36px;">
                                            <table border="0" align="center" cellpadding="0" cellspacing="0"
                                                role="presentation">
                                                <tr>
                                                    <td width="10"></td>
                                                    <td align="center">
                                                        <a href="{{ settings('social_instagram') }}" target="__blank">
                                                            <img style="width:36px;border:0px;display: inline!important;"
                                                                {{ asset('assets/img/Instagram.png') }}" width="36"
                                                                border="0" editable="true" data-icon data-image-edit
                                                                data-url data-label="Instagram" data-image-width
                                                                alt="icon">
                                                        </a>
                                                    </td>
                                                    <td width="10"></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td data-element="colibri-footer-twitter" data-label="Twitter"
                                            class="rwd-on-mobile" align="center" valign="middle" height="36"
                                            style="height: 36px;">
                                            <table border="0" align="center" cellpadding="0" cellspacing="0"
                                                role="presentation">
                                                <tr>
                                                    <td width="10"></td>
                                                    <td align="center">
                                                        <a href="{{ settings('social_linkedin') }}" target="__blank">
                                                            <img style="width:36px;border:0px;display: inline!important;"
                                                                {{ asset('assets/img/Twitter.png') }}" width="36"
                                                                border="0" editable="true" data-icon data-image-edit
                                                                data-url data-label="Twitter" data-image-width
                                                                alt="icon">
                                                        </a>
                                                    </td>
                                                    <td width="10"></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td data-element="colibri-footer-pinterest" data-label="Pinterest"
                                            class="rwd-on-mobile" align="center" valign="middle" height="36"
                                            style="height: 36px;">
                                            <table border="0" align="center" cellpadding="0" cellspacing="0"
                                                role="presentation">
                                                <tr>
                                                    <td width="10"></td>
                                                    <td align="center">
                                                        <a href="{{ settings('social_tiktok') }}" target="__blank">
                                                            <img style="width:36px;border:0px;display: inline!important;"
                                                                {{ asset('assets/img/Tiktok.png') }}" width="36"
                                                                border="0" editable="true" data-icon
                                                                data-image-edit data-url data-label="Pinterest"
                                                                data-image-width alt="icon">
                                                        </a>
                                                    </td>
                                                    <td width="10"></td>
                                                </tr>
                                            </table>
                                        </td>
                                        <td data-element="colibri-footer-pinterest" data-label="Pinterest"
                                            class="rwd-on-mobile" align="center" valign="middle" height="36"
                                            style="height: 36px;">
                                            <table border="0" align="center" cellpadding="0" cellspacing="0"
                                                role="presentation">
                                                <tr>
                                                    <td width="10"></td>
                                                    <td align="center">
                                                        <a href="{{ settings('social_whatsapp') }}" target="__blank">
                                                            <img style="width:36px;border:0px;display: inline!important;"
                                                                src="{{ asset('assets/img/whatsapp.svg') }}"
                                                                width="36" border="0" editable="true"
                                                                data-icon data-image-edit data-url
                                                                data-label="Pinterest" data-image-width
                                                                alt="icon">
                                                        </a>
                                                    </td>
                                                    <td width="10"></td>
                                                </tr>
                                            </table>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                    <!-- Social Icons -->
                </td>
            </tr>
            <tr data-element="colibri-footer-social-icons" data-label="Social Icons">
                <td height="60" style="font-size:60px;line-height:60px;" data-height="Spacing under social icons">
                    &nbsp;</td>
            </tr>
            <tr>
                <td class="content-cell" align="center">
                    {{ Illuminate\Mail\Markdown::parse($slot) }}
                </td>
            </tr>
        </table>
    </td>
</tr>
