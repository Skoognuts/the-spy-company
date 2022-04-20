# THE SPY COMPANY
Evaluation Back-End : Créer une Application Web

## Contexte du projet : la BDD
- Les agents ont un nom, un prénom, une date de naissance, un code d'identification, une nationalité, 1
ou plusieurs spécialités.
- Les cibles ont un nom, un prénom, une date de naissance, un nom de code, une nationalité.
- Les contacts ont un nom, un prénom, une date de naissance, un nom de code, une nationalité.
- Les planques ont un code, une adresse, un pays, un type.
- Les missions ont un titre, une description, un nom de code, un pays, 1 ou plusieurs agents, 1 ou
plusieurs contacts, 1 ou plusieurs cibles, un type de mission (Surveillance, Assassinat, Infiltration …), un
statut (En préparation, en cours, terminé, échec), 0 ou plusieurs planque, 1 spécialité requise, date de
début, date de fin.
- Les administrateurs ont un nom, un prénom, une adresse mail, un mot de passe, une date de création.

## Règle métier :
- Sur une mission, la ou les cibles ne peuvent pas avoir la même nationalité que le ou les agents.
- Sur une mission, les contacts sont obligatoirement de la nationalité du pays de la mission.
- Sur une mission, la planque est obligatoirement dans le même pays que la mission.
- Sur une mission, il faut assigner au moins 1 agent disposant de la spécialité requise.

## Modalités Pédagogiques :
Il vous est demandé de créer la base de données selon cette description. Tous les champs devront
avoir les bons types, avec optimisation. Il faut également créer les liens entre les différentes tables.
Certaines colonnes sont peut-être manquantes et nécessaires à votre développement, à vous de les
fournir. Aucun jeu de données n’est fourni. Il faudra présenter un schéma de conception (MCD/MLD).
Il faudra créer un script de création de la base, facilement exécutable pour une création rapide.
Il vous est ensuite demandé de créer une interface front-office, accessible à tous, permettant de
consulter la liste de toutes les missions, ainsi qu’une page permettant de voir le détail d’une mission.
De plus, il faudra créer une interface back-office, uniquement accessible aux utilisateurs de rôle ADMIN,
qui va permettre de gérer la base de données de la bibliothèque. Ce back-office va permettre de lister,
créer, modifier et supprimer chaque donnée des différentes tables, grâce à des formulaires et des tableaux. 
Il faut que ces pages ne soient pas accessibles à tout le monde ! Il faudra donc créer une page de connexion 
et de déconnexion (pas de page d'inscription). Il faut réaliser le projet en programmation orienté objet,
de type MVC (Model Vue Controller). Chaque table de la base de données sera représentée par un objet PHP.
