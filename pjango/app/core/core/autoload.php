<?php
spl_autoload_register(function($class){
    if(file_exists("../../vendor/classes/". $class . ".php")){
        require_once '../../vendor/classes/' . $class . '.php';
    }else if(file_exists("../../vendor/handlers/". $class . ".php")){
        require_once '../../vendor/handlers/' . $class . '.php';
    }else if(file_exists("../../vendor/controllers/". $class . ".php")){
        require_once '../../vendor/controllers/' . $class . '.php';
    }else if(file_exists("../../FormControllers/". $class . ".php")){
        require_once '../../FormControllers/' . $class . '.php';
    }else if(file_exists("../../../vendor/handlers/". $class . ".php")){
        require_once '../../../vendor/handlers/' . $class . '.php';
    }else if(file_exists("../../../vendor/controllers/". $class . ".php")){
        require_once '../../../vendor/controllers/' . $class . '.php';
    }else if(file_exists("../../../FormControllers/". $class . ".php")){
        require_once '../../../FormControllers/' . $class . '.php';
    }else if(file_exists("../../../vendor/classes/". $class . ".php")){
        require_once '../../../vendor/classes/' . $class . '.php';
    }


    else if(file_exists("../../../../vendor/handlers/". $class . ".php")){
        require_once '../../../../vendor/handlers/' . $class . '.php';
    }else if(file_exists("../../../../vendor/controllers/". $class . ".php")){
        require_once '../../../../vendor/controllers/' . $class . '.php';
    }else if(file_exists("../../../FormControllers/". $class . ".php")){
        require_once '../../../../FormControllers/' . $class . '.php';
    }else if(file_exists("../../../vendor/classes/". $class . ".php")){
        require_once '../../../../vendor/classes/' . $class . '.php';
    }
    else{
        require_once 'addons/' . $class . '.php';
    }
});
if(file_exists("vendor/functions/sanitize.php")){
    require_once "vendor/functions/sanitize.php";
}
 if(file_exists("../vendor/functions/sanitize.php")){
    require_once "../vendor/functions/sanitize.php";
}
 if(file_exists("../../vendor/functions/sanitize.php")){
    require_once "../../vendor/functions/sanitize.php";
}
 if(file_exists("../../../vendor/functions/sanitize.php")){
    require_once "../../../vendor/functions/sanitize.php";
}
 if(file_exists("vendor/config/default_config.php")){
    require_once "vendor/config/default_config.php";
}
 if(file_exists("../vendor/config/default_config.php")){
    require_once "../vendor/config/default_config.php";
}
 if(file_exists("../../vendor/config/default_config.php")){
    require_once "../../vendor/config/default_config.php";
}
if(file_exists("../../../vendor/config/default_config.php")){
    require_once "../../../vendor/config/default_config.php";

}
if(file_exists("vendor/config/admin.php")){
    require_once "vendor/config/admin.php";
}
if(file_exists("../vendor/config/admin.php")){
    require_once "../vendor/config/admin.php";
}
if(file_exists("../../vendor/config/admin.php")){
    require_once "../../vendor/config/admin.php";
}
if(file_exists("../../../vendor/config/admin.php")){
    require_once "../../../vendor/config/admin.php";


}if(file_exists("schemas/tables.php")){
    require_once "schemas/tables.php";
}if(file_exists("../schemas/tables.php")){
    require_once "../schemas/tables.php";
}
if(file_exists("../../schemas/tables.php")){
    require_once "../../schemas/tables.php";
}
if(file_exists("../../../schemas/tables.php")){
    require_once "../../../schemas/tables.php";
}
if(file_exists("../../../../schemas/tables.php")){
    require_once "../../../../schemas/tables.php";
}




