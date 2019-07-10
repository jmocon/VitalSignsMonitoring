<?php
$clsFn = new Fn();
class Fn{

	public function __construct(){}

	public function setForm($name, &$mdl, $required=false){
		$msg = "";
    $missing = false;

		if(isset($_POST[$name])){
			$mdl->{'set'.$name}($_POST[$name]);
      if ($_POST[$name] == '') {
        $missing = true;
      }
		}else{
      $missing = true;
		}

    if($required && $missing){
      $msg .= "<p class='m-0'>";
      $msg .= $name." missing.";
      $msg .= "</p>";
    }

		return $msg;
	}

  public function setVar($name, &$var, $method='post', $required=true, $empty=false){
		/*
		$method 	= POST | GET
		$name 		= name of method for superglobals
		$var			= variable where the output will be placed
		$required	= true: must not be empty string
		$empty		= must pass the empty() condition

		return		= missing message (Bootstrap Based)
		*/

    $output = "";
    $method = strtolower($method);

    if ($method == 'get') {
			if (isset($_GET[$name])) {
        $var = $_GET[$name];
			}
    } else if($method == 'post'){
      if (isset($_POST[$name])) {
        $var = $_POST[$name];
      }
    } else {
      die('method not defined properly');
    }

		if ($required) {
			if ($empty) {
				$output .= "<p class='m-0'>";
	      $output .= $name." missing.";
	      $output .= "</p>";
			} else if ($var == '') {
				$output .= "<p class='m-0'>";
	      $output .= $name." missing.";
	      $output .= "</p>";
			}
		}

    return $output;
  }

  public function Pagination($page=1, $totalItem=0, $btnperPage=5,$perPage=10)
  {
    $pageQuery = '';
    foreach ($_GET as $key => $value) {
      if($key != "page"){
        $pageQuery .= $key ."=". $value ."&";
      }
    }
    $maxPage = $totalItem/$perPage;
    $btnStart = floor(($page-1)/$btnperPage)*$btnperPage;
    ?>

    <nav class="d-flex">
      <ul class="pagination mx-auto justify-content-center">
        <li class="page-item <?php echo ((($btnStart) <=1)?'disabled':''); ?>">
          <a class="page-link" href="? <?php echo $pageQuery; ?>page=<?php echo($btnStart);?>" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
          </a>
        </li>

        <?php
        for ($i=1; $i < $btnperPage+1; $i++) {
          if($maxPage >= ($btnStart+$i)){
            echo '<li class="page-item '.((($btnStart+$i)==$page)?'active':'').'"><a class="page-link" href="?'.$pageQuery.'page='.($btnStart+$i).'">'.($btnStart+$i).'</a></li>';
          }
        }
        ?>

        <li class="page-item <?php echo ((($btnStart+$i+1) <= $maxPage)?'':'disabled'); ?>">
          <a class="page-link" href="? <?php echo $pageQuery; ?>page=<?php echo($btnStart+6);?>" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
          </a>
        </li>
      </ul>
    </nav>
    <?php
  }

	public function Alert($color,$body,$title="",$subTitle="") {
		?>
		<div class="alert alert-<?php echo $color; ?>" role="alert">
		  <h4 class="alert-heading">Well done!</h4>
		  <p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
		  <hr>
		  <p class="mb-0">Whenever you need to, be sure to use margin utilities to keep things nice and tidy.</p>
		</div>
		<?php
	}

}
