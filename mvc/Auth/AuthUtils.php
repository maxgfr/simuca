<?php


    /** @brief utillitaires de connextion (validation REGEX du mot de passe)*/
    class AuthUtils {

        /** Fonction qui teste si un mot de passe est suffisament difficile*/
        /** @param $woulBePasswd mot de passe (non hasé) saisi par l'utilisateur*/
        public static function isStrongPassword($wouldBePasswd)
        {
            $lengthCondition = (strlen($wouldBePasswd)>= 8 && strlen ($wouldBePasswd) <= 35 );
            // évaluation des expressions régulières
            $CharacterDiversityCondition = preg_match("/[a-z]/",$wouldBePasswd) && preg_match("/[A-Z]/", $wouldBePasswd ) && preg_match("/[0-9]/", $wouldBePasswd) && preg_match("/[\#\-\|\.\@\[\]\=\!\&]/", $wouldBePasswd);
            return $lengthCondition && $CharacterDiversityCondition;
        }

    }
?>