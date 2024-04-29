<?php
require __DIR__ . "/vendor/autoload.php";
use Jumbojett\OpenIDConnectClient;

// we need the session to store OpenID Connect protocol data
session_start();

if (!isset($_SESSION["oidc"])) {
    $oidc = new OpenIDConnectClient("https://www.e-contract.be/eid-idp/oidc/auth/");
    // store the OpenID Connect client within the HTTP session
    $_SESSION["oidc"] = $oidc;
    // next really seems to be required
    $oidc->setClientName("Example Web Application");
}

$oidc = $_SESSION["oidc"];

if (!isset($_REQUEST["code"])) {
    // OpenID Connect Dynamic Client Registration
    $oidc->register();
}

// optionally add other OpenID Connect scopes
$oidc->addScope(["address", "photo"]);

// enable PKCE
$oidc->setCodeChallengeMethod("S256");

$oidc->authenticate();
$userinfo = $oidc->requestUserInfo();

// important to check for identification or authentication flow
if ($userinfo->acr !== "urn:be:e-contract:idp:oidc:acr:auth") {
    exit("Invalid ACR.");
}
?>

<html>
    <head>
        <title>Authentication Example</title>
    </head>
    <body>
        <h1>Authentication Example</h1>
        <table>
        <?php
            foreach ($userinfo as $key => $value) {
                print "<tr>";
                print "<td>$key</td>";
                print "<td>";
                if (is_object($value)) {
                    print "<table>";
                    foreach ($value as $obj_key => $obj_value) {
                        print "<tr>";
                        print "<td>$obj_key</td>";
                        print "<td>$obj_value</td>";
                        print "</tr>";
                    }
                    print "</table>";
                } else {
                    if ($key === "photo") {
                        print '<img src="data:image/jpg;base64,' . $userinfo->photo . '"/>';
                    } else {
                        print $value;
                    }
                }
                print "</td>";
                print "</tr>";
            }
        ?>
        </table>
        <p>
            <a href="./">Back</a>
        </p>
    </body>
</html>

<?php
    unset($_SESSION["oidc"]);
?>
