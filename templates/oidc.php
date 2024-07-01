<?php

$headers = apache_request_headers();

?>
<table>
    <tr> <td align="right">NAME :</td> <td><?php echo $headers['OIDC_CLAIM_name']; ?></td> </tr>
    <tr> <td align="right">EMAIL :</td> <td><?php echo $headers['OIDC_CLAIM_email']; ?></td> </tr>
    <tr> <td align="right">IDP NAME :</td> <td><?php echo $headers['OIDC_CLAIM_idp_name']; ?></td> </tr>
    <tr> <td align="right">IDP :</td> <td><?php echo $headers['OIDC_CLAIM_idp']; ?></td> </tr>
    <tr> <td align="right">EPPN :</td> <td><?php echo $headers['OIDC_CLAIM_eppn']; ?></td> </tr>
</table>