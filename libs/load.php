<?
include_once 'includes/Database.class.php';
include_once 'includes/User.class.php';
include_once 'includes/Session.class.php';
include_once 'includes/docker.class.php';

Session::start();
$dockerAPI = new DockerContainerAPI;
$dockerAPI->container_info();


function load_template($name)
{
    include $_SERVER['DOCUMENT_ROOT']."/_templates/$name.php"; //not consistant.
}



 

 