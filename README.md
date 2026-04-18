V pgAdmin si treba vytvoriť databázu. V do optidivy projektového suboru treba prisať file s názvom db.properties, ktorého obsah bude vyzerať nasledovne:

url=jdbc:postgresql://localhost:5432/{{názov databázy}}
user={{váš user name na pgAdmine, pravdepodobne postgres}}
password={{vaše heslo do pgAdminu, alternatívne môžete nechať prázdne ak si viete nastaviť prístup bez hesla v pgAdmine}}
