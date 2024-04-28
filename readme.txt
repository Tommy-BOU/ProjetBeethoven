Voici les étapes pour installer le projet :

récupérer le dossier sur le repo a https://github.com/Tommy-BOU/ProjetBeethoven

mettre les fichiers .env et .env.test fournis avec ce fichier dans le dossier racine du projet.

ouvrir le dossier avec vscode, puis dans le terminal entrer la commande : composer install

créer la base de données avec : symfony console doctrine:database:create

créer les entités dans la base de données avec : symfony console make:migration puis symfony console d:m:m

ensuite deux possibilités, soit chargé les fixtures avec symfony console d:f:l, cela chargera des livres, des utilisateurs "factices", des prêts qui leur sont raccordés et un admin dans la base de donnée. Il sera alors possible de se connecter avec l'email admin@admin.com et le mot de passe "admin" pour accéder à toutes les fonctionnalités.

soit s'incrire sur le site et se rajouter le ROLE_ADMIN en dur dans la base de donnée.

Je recommande l'utilisation des fixtures, notamment pour tester certaines fonctionnalités lié au crud admin des emprunts.