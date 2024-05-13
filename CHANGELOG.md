# [3.6.0](https://github.com/vortechstudio/manager/compare/v3.5.0...v3.6.0) (2024-05-13)


### Bug Fixes

* **Railway Engine:** Correction du chemin d'accès aux fichiers .gif pour le type de train ([18d4350](https://github.com/vortechstudio/manager/commit/18d435033595e40a9b8c3346ac2e63684faa148f))
* **Utilisateurs:** Ajout de liaison avec le modele UserRailwaySocial ([d26d1ff](https://github.com/vortechstudio/manager/commit/d26d1ff460bfdbb69adc094018f800931ba32e7a))


### Features

* **Railway Social:** Ajout de UserRailwaySocial et de sa migration ([d90b575](https://github.com/vortechstudio/manager/commit/d90b57577aecd69680e04f5231a138e8a2650d65))

# [3.5.0](https://github.com/vortechstudio/manager/compare/v3.4.0...v3.5.0) (2024-05-10)


### Bug Fixes

* **Social Cercle:** Mise à jour des vues et du modèle des cercles sociaux ([7c8d943](https://github.com/vortechstudio/manager/commit/7c8d9433680287cad8299c2b9b64512e2a79677f))
* **Social Evenement:** migrate event creation form to livewire component ([93f3942](https://github.com/vortechstudio/manager/commit/93f3942063bc771327e5f2f79e78d34ded3846c2))
* **Social Evenement:** remplacement du code dans show.blade.php ([42f4b16](https://github.com/vortechstudio/manager/commit/42f4b16fe7e1b3ddbf19407a17f3647f487b2635))


### Features

* **Social Cercle:** Ajout du composant 'CercleImage' permettant d'upload les images du cercle ([0d75dec](https://github.com/vortechstudio/manager/commit/0d75decb19269d53fbeefc937c06fd7372cffd57))
* **Social Evenement:** Ajout de l'onglet de contenu de l'événement ([3ecc9eb](https://github.com/vortechstudio/manager/commit/3ecc9eba336bb9d3b8640878780626b7f4cfdb40))
* **Social Evenement:** Ajout du formulaire d'upload d'image pour les événements ([c9829c8](https://github.com/vortechstudio/manager/commit/c9829c84983ef908503e6ca62f45e4fc1b1ab1c4))

# [3.4.0](https://github.com/vortechstudio/manager/compare/v3.3.0...v3.4.0) (2024-05-09)


### Features

* **Article:** Ajout attribut URL et sa méthode d'accès ([52826d7](https://github.com/vortechstudio/manager/commit/52826d7b26328c556599c64f49e9f497b3e5b94c))
* **article:** ajout de l'onglet images aux articles ([81b276c](https://github.com/vortechstudio/manager/commit/81b276ceed6855d25213500f8a84df2b0070eabe))
* **base de données, seeders:** Ajout du champ 'dossier' aux services et mise à jour de la logique de seeding ([740b01f](https://github.com/vortechstudio/manager/commit/740b01fc407edfe1a02d4bd64dd17a17c9858c1b))
* **Railway Quests:** Ajouter champs "action" et "action_count" à Quests ([e584ff2](https://github.com/vortechstudio/manager/commit/e584ff216b7119b0016b7c791551334b3016e413))
* **ServiceSeeder:** Ajout du champ 'premium' dans les seeders de service ([6087664](https://github.com/vortechstudio/manager/commit/6087664dd05dd61df57bef3d53162caa9ab16258))

# [3.3.0](https://github.com/vortechstudio/manager/compare/v3.2.0...v3.3.0) (2024-05-09)


### Bug Fixes

* **Railway Gares & Hubs:** Ajout de redirection et modification du formulaire ([c4ff492](https://github.com/vortechstudio/manager/commit/c4ff49289abf7a8590a9e5a0b12d3172e1f45480))


### Features

* **Railway Ligne:** Ajout de fonctionnalités pour activer/désactiver et supprimer une ligne ([3c74d8c](https://github.com/vortechstudio/manager/commit/3c74d8c08949d8cdf9c3742357b45ff3492b1c98))

# [3.2.0](https://github.com/vortechstudio/manager/compare/v3.1.0...v3.2.0) (2024-05-08)


### Bug Fixes

* **Railway Core:** Ajout et Mise à jour des modèles User et UserRailway ([fd12664](https://github.com/vortechstudio/manager/commit/fd126641581ade5b1bc97b5d88217b3c1da96ed2))


### Features

* **Service:** Ajout de la fonctionnalité de mise à jour des releases ([e2dff72](https://github.com/vortechstudio/manager/commit/e2dff727c2d8ec5c9f74335e067274f37ce473cd))
* **Service:** Ajout et mise à jour des fonctionnalités ([c8b4f56](https://github.com/vortechstudio/manager/commit/c8b4f5686bf12e4fc0999b633c1ad3e264f8c840))
* **UserRailway:** Ajout du modèle UserRailway et migration associée ([7ac6c85](https://github.com/vortechstudio/manager/commit/7ac6c857810168424478c0c0a27e724479da4a28))

# [3.1.0](https://github.com/vortechstudio/manager/compare/v3.0.0...v3.1.0) (2024-05-06)


### Bug Fixes

* Suppression du fichier app-8faf9869.js dans le dossier public/build/assets. ([62dfc2d](https://github.com/vortechstudio/manager/commit/62dfc2dae53f37a488b0ec07c84bee354d756876))


### Features

* **MenuSeeder, api:** Ajout de nouvelles routes et mises à jour du MenuSeeder ([1ad22f7](https://github.com/vortechstudio/manager/commit/1ad22f79cbe12b8395cefbc0bc895710bb826111))

# [3.0.0](https://github.com/vortechstudio/manager/compare/v2.3.1...v3.0.0) (2024-04-30)


### Bug Fixes

* **Railway Core:** Suppression de la prise en charge des saison pass, le système de quête se suffit à lui-même. ([b476aa2](https://github.com/vortechstudio/manager/commit/b476aa2cbfc3b1b7bcc854ed9e70552c8fe3ad30))
* **Railway Core:** Suppression de la prise en charge des tutoriels, le système de quête se suffit à lui-même. ([9cc1fed](https://github.com/vortechstudio/manager/commit/9cc1fedd37908a3b8da228b99e3022dd66ac1d68))


* Merge pull request #39 from vortechstudio/develop ([970dc36](https://github.com/vortechstudio/manager/commit/970dc369feb6836eeb85f3c09dc715aaa493aca6)), closes [#39](https://github.com/vortechstudio/manager/issues/39)


### Features

* **Railway Configuration:** Prise en charge de la configuration du système interne à railway manager. ([0e8b272](https://github.com/vortechstudio/manager/commit/0e8b27263a89689cbe90feafb16dc378db3df30c))


### BREAKING CHANGES

* Railway Manager Système de gestion terminer.

## [2.3.1](https://github.com/vortechstudio/manager/compare/v2.3.0...v2.3.1) (2024-04-29)


### Bug Fixes

* **Core:** Correction d'un bug sur le fichier de compilation applicatif ([57b69c1](https://github.com/vortechstudio/manager/commit/57b69c1558e01e177854be58886f04c3f00a0d6b)), closes [#15](https://github.com/vortechstudio/manager/issues/15)
* **Core:** Corrections mineurs ([40c78f8](https://github.com/vortechstudio/manager/commit/40c78f8fb3e99bdeca27b6a0ce7a50c289a89a56)), closes [#17](https://github.com/vortechstudio/manager/issues/17)
* **Core:** Corrections mineurs ([faef217](https://github.com/vortechstudio/manager/commit/faef217c5e6bb8f4b7f48d553332d0dce7a45cd3)), closes [#16](https://github.com/vortechstudio/manager/issues/16)
* **Social Article:** Correction du lien d'affichage de la preview d'un article dans le tableaucdes articles. ([a66e29b](https://github.com/vortechstudio/manager/commit/a66e29b6c26c03e15efac1f827a29bf8c87696f8))
* **Social Article:** Correction du lien des images dans la vue d'un article. ([8e44ebd](https://github.com/vortechstudio/manager/commit/8e44ebdc4ffc9f971cad049697c44e29a926c373))
* **Social Article:** Redefinitions en cache de l'image d'un article. ([fea6f1e](https://github.com/vortechstudio/manager/commit/fea6f1e8e757d56343e159d9ee4a11bf4de36460))
* **Social Cercle:** Redefinitions en cache de l'image d'un cercle. ([d874cf0](https://github.com/vortechstudio/manager/commit/d874cf023079117512ef4462ad6a5caf2b4e303e))

# [2.3.0](https://github.com/vortechstudio/manager/compare/v2.2.0...v2.3.0) (2024-04-27)


### Bug Fixes

* **Horizon:** Correction et mise à jour des gates d'accès à Horizon. ([6763c42](https://github.com/vortechstudio/manager/commit/6763c421606e371409a6f5f48c8819e26d5f2bbf))
* **Horizon:** Suppression du gate horizon dans AppServiceProvider.php, il ne sert pas. ([d000831](https://github.com/vortechstudio/manager/commit/d0008317d2e5241c25d629679f52dff87f396c58))
* **Railway Porte Carte:** Correction du générateur automatique de porte carte, il rajoute le model_id si un type "engine" est selectionner et le nom du déclencheur suivant le type. ([058ae0c](https://github.com/vortechstudio/manager/commit/058ae0cee463145fa47ac7e2ac46cf6198c34598))


### Features

* **Railway Porte Carte:** Ajout d'un tableau de listing des portes-cartes ([8cd3d7a](https://github.com/vortechstudio/manager/commit/8cd3d7aa32362fd971b9317383b8d4ea4c695456))
* **Railway Porte Carte:** Ajout de l'action de rafraichissement des portes cartes, il supprime et recréez la base des portes cartes. Ajout de l'ajout manuel d'un porte-carte au besoin. ([3c70c5d](https://github.com/vortechstudio/manager/commit/3c70c5d5583bcb8574ddd2ba2f98f2c20287c1bc))
* **Railway Porte Carte:** Ajout de l'interface de gestion des portes cartes. ([96f348d](https://github.com/vortechstudio/manager/commit/96f348dff4de479a99db2ef8ccaa7694bf25bee8))
* **Railway Porte Carte:** Ajout de la fonction de génération automatique des porte carte. ([2f2583e](https://github.com/vortechstudio/manager/commit/2f2583e23b1069f8ffd1e91ae2f048e5a2c7feda))

# [2.2.0](https://github.com/vortechstudio/manager/compare/v2.1.0...v2.2.0) (2024-04-27)


### Features

* **Railway Bonus:** Ajout d'une notification à l'administrateur lors du renouvellement des bonus mensuel. ([1eacf78](https://github.com/vortechstudio/manager/commit/1eacf783973d3cf41fb78265d47cca1179472320))
* **Railway Bonus:** Ajout visuel de type alerte pour alerter l'utilisateur de la réinitialisation des bonus dans X temps. ([a5f6e8b](https://github.com/vortechstudio/manager/commit/a5f6e8b783aea87f59a4fa217b1c0c8f58d9b3a9))

# [2.1.0](https://github.com/vortechstudio/manager/compare/v2.0.0...v2.1.0) (2024-04-26)


### Bug Fixes

* **Railway Bonus:** Correction de la table ([fa9fe2a](https://github.com/vortechstudio/manager/commit/fa9fe2a43f5a31b84f8783a222e50bf9f16f5780))


### Features

* **Railway Bonus:** Ajout de la prise en charge des bonus journalier. ([53096e2](https://github.com/vortechstudio/manager/commit/53096e20c67e74b0b534bd451bc02ef9a6c22782))
* **Railway Bonus:** Ajout de la prise en charge des bonus journalier. ([1d4a2f2](https://github.com/vortechstudio/manager/commit/1d4a2f2b2ae3af997f1c60584ba6659cf2820fd1))

# [2.0.0](https://github.com/vortechstudio/manager/compare/v1.0.0...v2.0.0) (2024-04-26)


### Bug Fixes

* Ajout de la fonctionnalité de mise à jour de la distance et de calcul du prix de la ligne dans LignePanelInfo.php ([052a1d1](https://github.com/vortechstudio/manager/commit/052a1d1f83587a376344a800781726446caf0fca))
* Ajout de la méthode getImageAttribute pour récupérer l'image du logo de la location de train ([13e0932](https://github.com/vortechstudio/manager/commit/13e0932d3d36b1045c9e3800daa5856024a0486a))
* Ajout de la méthode getSlugAttribute dans RailwayEngine.php ([0cdac7c](https://github.com/vortechstudio/manager/commit/0cdac7ca8aba15e5c909e7166d6aaaead25a548d))
* Ajout des attributs is_hub et type_gare_string dans RailwayGare.php ([5fe2787](https://github.com/vortechstudio/manager/commit/5fe278725c8ca605209016aa389b67642eefa813))
* Ajout du composant Livewire pour la table des emplacements de location dans la vue index.blade.php ([41fcdbc](https://github.com/vortechstudio/manager/commit/41fcdbc79dfd7f06a5cc7c5b8fdc3f5e0154adf1))
* Ajouter une virgule manquante dans les coordonnées de longitude de la gare dans HubController ([bc7b814](https://github.com/vortechstudio/manager/commit/bc7b814e979b14dd2158e44aba8c905c43025ab0))
* **Authentification:** Correction des informations email lors de la connexion d'un utilisateur (New Device). ([f986081](https://github.com/vortechstudio/manager/commit/f986081254b487abbb16841c8e3757a92d8a9916))
* charger les relations price, shop et technical lors de l'affichage d'un moteur de train dans MaterielController ([45f04c4](https://github.com/vortechstudio/manager/commit/45f04c4462ef2fb7cd227928193bbd5ba55c944f))
* **Controller:** corrige l'utilisation de la fonction Str::uuid() ([585a8cb](https://github.com/vortechstudio/manager/commit/585a8cb6f7344baa6098332adb00ed6429074bdf))
* Correction de l'upload des images pour les locations de chemins de fer ([59880d2](https://github.com/vortechstudio/manager/commit/59880d2690798d030bbbb3c943e0efe93a61092d))
* Correction de la casse dans la valeur de l'id pour l'option électrique 1500V ([b6f2e53](https://github.com/vortechstudio/manager/commit/b6f2e53cb93d1292753811aad435a85a66425ea9))
* Correction de la gestion des cercles dans ArticleController ([6d80bb2](https://github.com/vortechstudio/manager/commit/6d80bb29d5dfa396e9b8d789fdde6fed68af6917))
* Correction de la relation entre RailwayLevel et RailwayLevelReward ([d5c0d87](https://github.com/vortechstudio/manager/commit/d5c0d87499880853977b85c9842d5ef992587f70))
* Correction du format de l'image dans le selecteur de type de matériel acceptée ([6b9d6dc](https://github.com/vortechstudio/manager/commit/6b9d6dce8aafe26aae64174edb2d6a833079e73d))
* Correction du nom de la route pour confirmer le mot de passe dans le fichier routes/web.php ([df0be47](https://github.com/vortechstudio/manager/commit/df0be4782fd8e9a51da6a04490d5c758d05fcf95))
* corrige l'affichage du titre dans la barre d'outils ([9b89987](https://github.com/vortechstudio/manager/commit/9b89987c7af1391024ae6efa42c62ca7bed7c90c))
* corrige la clé étrangère dans la relation gare() ([#1234](https://github.com/vortechstudio/manager/issues/1234)) ([6e83ecf](https://github.com/vortechstudio/manager/commit/6e83ecf8cfe34940a0f75f651a02b34eb9479a71))
* Corrige le calcul des essieux dans EngineAction.php ([af7d8e4](https://github.com/vortechstudio/manager/commit/af7d8e48d43b69af0407a04ed71213882a099f69))
* corriger la faute d'orthographe dans le message de succès de l'ajout de matériel ([7c521a1](https://github.com/vortechstudio/manager/commit/7c521a1c0f18971569c2c8e6d6df373bd0a9a39c))
* corriger la fonctionnalité de désactivation/activation des gares ([99672a0](https://github.com/vortechstudio/manager/commit/99672a0660db3002150e3d2cce7386321a8168b5))
* Corriger la recherche des gares dans HubTable.php ([611f5c3](https://github.com/vortechstudio/manager/commit/611f5c329baa5028c16578bd7929073d21818ad3))
* Corriger le nom de la clé étrangère dans la relation RailwayLigne avec RailwayHub ([cb10b90](https://github.com/vortechstudio/manager/commit/cb10b9059c07fb3ea67cb58f4c0eaba1a61daf01))
* Corriger les chemins des répertoires dans les fichiers .env.staging et .env.production ([e8343c5](https://github.com/vortechstudio/manager/commit/e8343c51e8db1a4b9c289a818a616dac97ad02dc))
* corriger les valeurs des options de transports dans les vues de création de gares ferroviaires ([51af617](https://github.com/vortechstudio/manager/commit/51af617c9e45b06ef539bc7b0c93721a8bcad808))
* **erreur:** Correction de l'erreur de syntaxe dans le fichier EngineSelectAction.php ([bbb7dc2](https://github.com/vortechstudio/manager/commit/bbb7dc2d17c6fca2f3678c5b4c48ccc193a8a214))
* initialiser la variable railway_gare_id à 0 ([6e52ef3](https://github.com/vortechstudio/manager/commit/6e52ef350497fbac285c7d1ba2c1bf4af6f463a5))
* Mettre à jour la version de Node.js à 20 dans le fichier de configuration de la release ([12f9e26](https://github.com/vortechstudio/manager/commit/12f9e262d94023a91177ca215b7cf1e542634a70))
* Mettre à jour les chemins de déploiement pour le staging et la production ([9b39daf](https://github.com/vortechstudio/manager/commit/9b39daf5e4e7640b299525fcea551e1052c498b0))
* Mettre à jour les configurations de déploiement pour le staging et la production ([6a3ec0f](https://github.com/vortechstudio/manager/commit/6a3ec0f872417b9986658645a131df639dc0533d))
* **Optimisation:** Minification des assets ([8e47834](https://github.com/vortechstudio/manager/commit/8e47834e9e89072772cad3e96fcfa7180a29e380))
* **Optimisation:** Mise en cache de l'application ([79eaba2](https://github.com/vortechstudio/manager/commit/79eaba20d011cf8910518f3b91ef47a81ce86a05))
* **Optimisation:** Optimisation de composer ([df526f9](https://github.com/vortechstudio/manager/commit/df526f912cbcf13efc089484cb398e611eeb397f))
* **Optimisation:** Optimisation des packages ([0e82c3b](https://github.com/vortechstudio/manager/commit/0e82c3b9d58af6e8dbd0c9d355faede0f334baa7))
* **Optimisation:** Optimisation des packages ([aa20a2f](https://github.com/vortechstudio/manager/commit/aa20a2fb81952efd55aca2a309debbfdfb7037d4))
* **Optimisation:** Optimisation Eager Loading ([fb8d6f0](https://github.com/vortechstudio/manager/commit/fb8d6f044638edef35981652dfb3364ab847d38e)), closes [#1234](https://github.com/vortechstudio/manager/issues/1234)
* **Railway Banque:** Correction de la notification envoyé lors de la mise à jour des flux bancaires. ([538aeb8](https://github.com/vortechstudio/manager/commit/538aeb8f02ce6d525ed89238dc82108834e9253c))
* **Railway Finance:** Correction de bug mineur ([87e7298](https://github.com/vortechstudio/manager/commit/87e729877962eae77af204df1562616c854fb7c7))
* **Railway Finance:** Modification des fichiers de base de donnée ([f486aa1](https://github.com/vortechstudio/manager/commit/f486aa1f484bac698209bb041ca4263163570bb5))
* **Railway Rental:** Correction de la mise en cache des images des services de location. ([0e8296f](https://github.com/vortechstudio/manager/commit/0e8296f9814b2065d7e21fcb081a3b901b29cbfc))
* **Railway/Ligne:** Ajouter le champ 'name' à la table 'railway_lignes' ([d4012c8](https://github.com/vortechstudio/manager/commit/d4012c8890b4a6da99f77341386c4761c32010dd))
* **Railway:** Ajout des cas de statut NULL, BETA et PROD dans le enum HubStatusEnum ([c55c1a6](https://github.com/vortechstudio/manager/commit/c55c1a65e8be12c9252a8cdf23371e3e0fc35878))
* **Railway:** Modification de la génération des niveaux ([3fe7088](https://github.com/vortechstudio/manager/commit/3fe7088f6ae4ddbe885f4ebad085979321ee8733))
* **route:** Ajouter la route d'édition pour le matériel ferroviaire ([2fc5d90](https://github.com/vortechstudio/manager/commit/2fc5d9007f9d807375ca2858eb8618f4adc4ab3b))
* **Social Évènement:** L'affichage du tableau a été restitué. ([434bc27](https://github.com/vortechstudio/manager/commit/434bc2734017e1910f50204988714cc5b1b462b1))


### core

* **System:** Update Framework ([d4b9efd](https://github.com/vortechstudio/manager/commit/d4b9efd14add3a831c45c63b770e3df0d34b112b))


### Features

* **actions:** Ajout de la méthode selectorTypeTransport pour sélectionner le type de transport dans EngineSelectAction ([29a6734](https://github.com/vortechstudio/manager/commit/29a673438018c48e44e96f26da8ad819bccb7ce4))
* Ajout de la création d'une ligne dans les vues et le contrôleur ([d973648](https://github.com/vortechstudio/manager/commit/d9736487a8d7828358eca3c2f3b622d13078e334))
* Ajout de la création interactive d'un matériel roulant ([f3692a2](https://github.com/vortechstudio/manager/commit/f3692a253ebec389cb3c21f2ee91101d403a5987))
* Ajout de la création interactive d'un matériel roulant ([80973c8](https://github.com/vortechstudio/manager/commit/80973c84fd66f45af9b9dea7038ee1fe83db7a9f))
* Ajout de la fonction de notification pour Twitter ([8a9b223](https://github.com/vortechstudio/manager/commit/8a9b223bf1dc17160d2b9df0b65d923cbfb7abc1))
* Ajout de la gestion des stations sur la ligne de chemin de fer ([7de3457](https://github.com/vortechstudio/manager/commit/7de3457e3f360084965b9b5e0c75dc1e192e389d))
* Ajout de la gestion des stations sur la ligne de chemin de fer ([b9af5cb](https://github.com/vortechstudio/manager/commit/b9af5cb0268c6555292592d4ebf91d9d122336d2))
* Ajout de la migration pour la table de journalisation des connexions ([7904b89](https://github.com/vortechstudio/manager/commit/7904b89e34fac74080d6bc30d1d29abf6fa77433))
* Ajout de la valeur 'autre' à EngineTechMotorEnum.php ([ae47925](https://github.com/vortechstudio/manager/commit/ae47925cfee83c3bfcfd9c98b4a8d5b8ca401620))
* Ajout de la vue détaillée d'un matériel dans show.blade.php ([a69f70c](https://github.com/vortechstudio/manager/commit/a69f70c65799b0731f7407a7fdba261d53464d9e))
* Ajout du contrôleur QuestController pour gérer les quêtes dans le chemin de fer ([576a14b](https://github.com/vortechstudio/manager/commit/576a14b36377f3a9bf235ea1c45562c59a4990fe))
* Ajout du contrôleur QuestController pour gérer les quêtes dans le chemin de fer ([5c7bbfd](https://github.com/vortechstudio/manager/commit/5c7bbfd410bedeaa58df34a6d90329ead65e8678))
* Ajoute les migrations et les modèles pour les quêtes et récompenses de niveaux du chemin de fer ([da6bb3f](https://github.com/vortechstudio/manager/commit/da6bb3f2aa3a734acef6336e2c9e4d86b65abc15))
* Ajouter la méthode show pour afficher une gare dans HubController et la vue show.blade.php pour afficher les détails de la gare. ([b0d0bd6](https://github.com/vortechstudio/manager/commit/b0d0bd68ff5dffc03cb734a59f3d93189db93dfa))
* Ajouter les styles Livewire Dropzone ([db208ac](https://github.com/vortechstudio/manager/commit/db208accc39ab13d7d0658a4f4b87744af1f3102))
* Ajouter les styles Livewire Dropzone ([6bd4e3e](https://github.com/vortechstudio/manager/commit/6bd4e3e5051585c2bcc1548205ecfa70f454df16))
* **Banques:** Géneration aléatoire d'intérêts pour les banques Railway ([d80caee](https://github.com/vortechstudio/manager/commit/d80caee599b93511413b785fec6f22b481517caa))
* **Core:** Ajout de la fonctionnalité d'upload d'image et de contrôle de type ([600844d](https://github.com/vortechstudio/manager/commit/600844d0fa3bc123430968af0b1b207e06512bac))
* **gitignore:** Ajout de l'ignorance du répertoire public/build dans le fichier .gitignore ([f9507e8](https://github.com/vortechstudio/manager/commit/f9507e8e024bfaf94ba0dd1ebed291d74fb27dd5))
* **hubs:** Ajout du panneau d'information du hub ([93d3ce8](https://github.com/vortechstudio/manager/commit/93d3ce81f570afc95c0c5c919142ccdbdc5016dc))
* **ligne:** Ajout de la fonctionnalité pour ajouter une nouvelle station ([d2f077e](https://github.com/vortechstudio/manager/commit/d2f077ed8d59dcf3817caf43f5322c9989f479f6))
* **PWA:** Prise en charge du PWA ([630c6da](https://github.com/vortechstudio/manager/commit/630c6da56674ea013efe0a9e0b432d5d770524bf))
* **Quests:** Ajout de la fonctionnalité de gestion des quêtes ([69a69bd](https://github.com/vortechstudio/manager/commit/69a69bdb7a6f925cd67822141d005829bf3cfb2c))
* **Railway Banque:** Ajout du formatage du logo ([61cdfa3](https://github.com/vortechstudio/manager/commit/61cdfa3d7f573907bfd2591694c5cbabcda862b2))
* **Railway Banque:** Mise en place de l'upload du system de banque ([ff8c7a6](https://github.com/vortechstudio/manager/commit/ff8c7a668e21bccb413bfa6c5fbb7dab5eba8318))
* **Railway Banque:** Vue d'un service bancaire. ([a47cecb](https://github.com/vortechstudio/manager/commit/a47cecb6e107da9c158b7501bdf1e99e353c7600))
* **Railway Finance:** Ajout de fonction sur la vue d'un service financier ([65af067](https://github.com/vortechstudio/manager/commit/65af067391c90fd01063231f39763bf5f99f99d8))
* **Railway Finance:** Ajout du tableau de bord. ([54fd4c7](https://github.com/vortechstudio/manager/commit/54fd4c76c22da0962603753d52ddcb4cd5f8d0cc)), closes [#1234](https://github.com/vortechstudio/manager/issues/1234)
* **Railway Finance:** Ajout du tableau des services bancaire ([0f4dbb3](https://github.com/vortechstudio/manager/commit/0f4dbb3646dd8ac572a6455903d8fd57e7b084d5))
* **Railway Finance:** Ajout sur la vue d'un service financier ([90d40f6](https://github.com/vortechstudio/manager/commit/90d40f623cc51c8558307ebbfc3605473dc38c73))
* **Railway Finance:** Gestion des Services bancaires ([bea3cca](https://github.com/vortechstudio/manager/commit/bea3ccac26f6bcfe8ac2ae4ab0288f4648f559dc))
* **Railway/Engine:** Ajout de la fonctionnalité d'affichage d'un moteur ferroviaire ([e7e269c](https://github.com/vortechstudio/manager/commit/e7e269c003abf0baf8f4aecacf6cf33d6ef679dc))
* **Railway/Ligne:** Ajout de la classe LigneStationAction pour gérer les calculs de distance, vitesse et temps de trajet ([f8333b2](https://github.com/vortechstudio/manager/commit/f8333b221f0de7462a3e36047aad2db011dc7629))
* **Railway/Ligne:** Ajout de la classe LigneStationAction pour gérer les calculs de distance, vitesse et temps de trajet ([a19ee53](https://github.com/vortechstudio/manager/commit/a19ee535d3ca49031f30c9db00e00668575ac957))
* **Railway/Ligne:** Ajout du contrôleur LigneController pour gérer les lignes de chemin de fer ([e61bc55](https://github.com/vortechstudio/manager/commit/e61bc5582f56afde5b8a3a752bc9906507d2ff17))
* **Railway/Location:** Ajout du composant Livewire LocationTable pour gérer l'affichage des services de location ([2ca444e](https://github.com/vortechstudio/manager/commit/2ca444e5f77bdbb7bca085bae0de07af649cd8dc))
* **railway/Location:** Préparation à la mise en place de la gestion des services de location. ([1e7f898](https://github.com/vortechstudio/manager/commit/1e7f898a8e0b8266b98db382e703e69b384fc692))
* **Railway:** Ajout de fonctionnalités pour désactiver, activer, mettre en production et supprimer un moteur de train ([b36b0c5](https://github.com/vortechstudio/manager/commit/b36b0c59c23ee1f5bb03e20ecb58bc36840b342e))
* **Railway:** Ajout de la classe GareAction pour gérer les informations et calculs liés aux gares ferroviaires ([88db4bf](https://github.com/vortechstudio/manager/commit/88db4bf374c68f47648eae9f78bb6be6021ede05))
* **Railway:** Ajout de la création d'une gare avec gestion des hubs ([b38da05](https://github.com/vortechstudio/manager/commit/b38da05c883c4ea05a4d9bb07929adb46efc355d))
* **Railway:** Ajout de la création d'une ligne de chemin de fer ([bffde07](https://github.com/vortechstudio/manager/commit/bffde07fd91e26d244b6da23a9d123d5e0b64fb4))
* **Railway:** Ajout de la fonction destroy pour supprimer un moteur ([6171445](https://github.com/vortechstudio/manager/commit/61714459f10e742024a2bf7ee1b600c33fa76d05))
* **Railway:** Ajout de la fonctionnalité de gestion des stations de la ligne ([a04a7be](https://github.com/vortechstudio/manager/commit/a04a7be618d26792dd4ef453c2c11bbcab68299c))
* **railway:** Ajout de la fonctionnalité de pagination dans la table des lignes ([dd36002](https://github.com/vortechstudio/manager/commit/dd3600268a50abea66e0313950d6d4c484155905))
* **Railway:** Ajout de la fonctionnalité de pagination et de recherche dans la table des gares ([8c18239](https://github.com/vortechstudio/manager/commit/8c18239a82a38ffb25f597576579225e7b67a971))
* **railway:** Ajout de la génération automatique des niveaux et des récompenses ([f0d03c6](https://github.com/vortechstudio/manager/commit/f0d03c697316ee13ee89c4cae6b6a374a131505b))
* **railway:** Ajout de la gestion des Gares & Hubs ([b48f673](https://github.com/vortechstudio/manager/commit/b48f673c69ae844512c1676930683dac6337722c))
* **railway:** Ajout de la section "Gestion" pour afficher les informations sur le moteur ([3f9c721](https://github.com/vortechstudio/manager/commit/3f9c721a790ed5f64b966d480333058bff265121))
* **railway:** Ajout de la vue d'édition pour les matériels roulants ([ee444d6](https://github.com/vortechstudio/manager/commit/ee444d67270af14e0d4dcf03b88554953a6435e8))
* **railway:** Ajout de la vue de la boutique pour les moteurs de train ([111d705](https://github.com/vortechstudio/manager/commit/111d705a4ee2c8a49874b2c02455cf146537d696))
* **railway:** Ajout de la vue et de la logique pour afficher les actions des moteurs ([cf577ea](https://github.com/vortechstudio/manager/commit/cf577eae23a32134c697222830841affb31b4298))
* **railway:** Ajout de la vue et du composant pour afficher les détails techniques du moteur de train ([fcf3d81](https://github.com/vortechstudio/manager/commit/fcf3d81cb8007dc5af83129d3543d0c75e6b50d1))
* **railway:** Ajout des routes et du contrôleur pour la gestion des matériels roulants ([101cfe1](https://github.com/vortechstudio/manager/commit/101cfe19a646e54bb9288c667c1187e1c85f2d8a))
* **Railway:** Ajout du composant Livewire HubLigneTable pour afficher les lignes d'un hub ferroviaire et leur détails dans une table blade. ([7b982c6](https://github.com/vortechstudio/manager/commit/7b982c674938b81fd60a865710402a9ab57c07f4))
* **Railway:** Ajout du composant Livewire LevelTable pour la gestion des niveaux de quête dans Railway. ([7f442b6](https://github.com/vortechstudio/manager/commit/7f442b67c8411638ab0dff1dbdc63c23b928f658))
* **railway:** Ajoute la fonctionnalité d'affichage d'une ligne de chemin de fer ([d0e2986](https://github.com/vortechstudio/manager/commit/d0e29863744ff34b33a7339db3b01c5730698070))
* **Railway:** ajoute la fonctionnalité de création de gare ([e233935](https://github.com/vortechstudio/manager/commit/e2339357acfb9b4b66e02201c5d25edf701efa27))
* **railway:** Ajoute la localisation et les marqueurs initiaux sur la page de détail de la gare ([d647bd8](https://github.com/vortechstudio/manager/commit/d647bd84e7dd7f8df8663161189fcc253caf78a9))
* **railway:** Ajouter un champ id en tant que clé primaire dans la table railway_levels ([b23d098](https://github.com/vortechstudio/manager/commit/b23d098810a1dcf88e94cb73f083b1ad92ed42c1))
* **RailwayLevel:** Ajout de la propriété $guarded ([0257022](https://github.com/vortechstudio/manager/commit/02570227a49683bf6567e0441f0f61e7a8fc126f))
* **release:** Ajoute un workflow de release pour la branche production ([2974af0](https://github.com/vortechstudio/manager/commit/2974af0687de89e7ce1c4cad9694d539f0a2450f))
* **Routes:** Ajout de routes pour FinanceController ([582bff4](https://github.com/vortechstudio/manager/commit/582bff417cbaf768ddeea95ca2574695742b2284))
* **routes:** Ajout des routes pour les lignes de chemin de fer ([88098ad](https://github.com/vortechstudio/manager/commit/88098ad89d8b65043e5116e0adfdd78c1ee5a981))
* **Scheduled Actions:** Add a scheduled task to execute the 'dayly_flux' system action ([3df6505](https://github.com/vortechstudio/manager/commit/3df650515dfe249f6858f7fbbc0235e56cd713fd))
* **system:** ajouter la création de la ligne de chemin de fer entre les gares de départ et d'arrivée ([2186fcb](https://github.com/vortechstudio/manager/commit/2186fcb7267ff9518d9c33e343ec764a5160983f))


### BREAKING CHANGES

* **System:** Gestion des gares & hubs
* **railway:** Gestion des Gares & Hubs
