<?php
$email = <<< email
Dear {$firstName},
Welcome to the GameNomad community! To confirm your e-mail address, click on
the following URL:
{$this->config->website->url}/gamers/verify/key/{$registrationKey}
Questions? Comments? Contact us at {$this->config->email->support}!
Thank you,
The GameNomad Team
email;

?>