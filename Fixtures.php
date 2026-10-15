<?php
php bin/console cache:clear
php bin/console doctrine:migrations:status        # the migration should be "executed"
php bin/console doctrine:fixtures:load -n

for t in hackathon organisateur projet participant inscription equipe; do
    echo "=== $t ==="
    php bin/console dbal:run-sql "SELECT * FROM $t"
done

git add . && git commit -m "Ajout des entités, migration et fixtures"
