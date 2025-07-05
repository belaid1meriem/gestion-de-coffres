# gestion-de-coffres

## Pages: 
Login
Sign up
ajouter utilisateur
Home (liste des coffres)
Form crée coffre
Form modifier coffre
Historique codes secrets par coffre
Recherche par code secret

## Schéma BDD:
User(userId, nom, email, password)
Coffre(coffreId, nom)
Code(codeId, code)
Historique(historiqueId, codeId*, coffreId*, userId*, updatedAt)