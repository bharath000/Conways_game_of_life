<?php 

session_start();
if(!isset($_SESSION['use']))   // Checking whether the session is already there or not if 
    // true then header redirect it to the home page directly 
{
header("Location:login.php"); 
} 
require 'DB.php';
$name = $_SESSION['use'];
$timestamp = date('Y-m-d H:i:s');

time_stamp($timestamp,$name);
?>
<html>
<head>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

<!-- jQuery library -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<style>
    body {
  background:white;
}

#container {
  
  height: 800px;
  margin-right: 150px;;
  float: right;
  width: 1000px;
  background: white;
    border: 1px solid #f00;
  
}

#game{

}

#controls {
   
 
  width: 200px;
  
  background: white;
    border: 1px solid grey;
}

#round {
    padding: 5px;
}

#buttons {
    padding: 5px;
}

#buttons button {
    width: 100%;
}
.container{
   width: 90%;
    
}
.col-sm-8{
    width: auto;
    margin-left: 0px;

}
.navbar{
    background-color: darkblue;
    color: white;
}
.navbar-brand{
    color: white !important;
   
    
}
.navbar-brand:hover{
    text-decoration: darkblue;
    color: darkblue !important;
    background-color: white !important;
}
.navbar-right{
    color: white !important;   
}

.nav1{
    color: white !important ;
}
.nav1:hover{
    color: darkblue !important ;
    background-color: white !important ;
}

</style>

<script src="http://code.jquery.com/jquery-1.10.2.js"></script>
<script src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
</head>
<body>
    <nav class="navbar navbar-inverse">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>                        
            </button>
            <a class="navbar-brand" href="#">The L I F E Game</a>
          </div>
          <div class="collapse navbar-collapse" id="myNavbar">
           <!-- <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
              
              <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="#">Page 1-1</a></li>
                  <li><a href="#">Page 1-2</a></li>
                  <li><a href="#">Page 1-3</a></li>
                </ul>
              </li>
              <li><a href="#">Page 2</a></li>
              <li><a href="#">Page 3</a></li>
            </ul>-->
            <ul class="nav navbar-nav navbar-right">
              <li><a class = "nav1" href="index.php"><span class="glyphicon glyphicon-user"></span> <?php echo $name; ?></a></li>
              <li><a class="nav1" href="logout.php"><span class="glyphicon glyphicon-log-in"></span> Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>


<div  class='container'>
  <div class="row">
    <div id="controls" class = 'col-sm-2'>
        <div id="round">Round: <span>0</span></div>
        
        <div id="buttons">
          <button id="run" type="button"class="btn btn-primary">Start</button><br>
          <button id="step" type="button"class="btn btn-primary">Increment-1</button><br>
          <button id="step23" type="button"class="btn btn-primary">Increment-23</button><br>
          <button id="clear" type="button"class="btn btn-primary">Clear</button><br>
          <button id="rand" type="button"class="btn btn-primary">Rand</button><br>
        </div>
      </div>

    
        <div class="col-sm-10">
    <canvas id="game" width="80" height="100"></canvas>
        </div>
  </div>
</div>

<br>
<br>
<br>

</body>
<script type=text/javascript>

    /* ***** GAME OF LIFE OBJECT ***** */

/**
 * Constructor for the Game of Life object
 * 
 * @author Qbit
 * @version 0.1
 */
function Game(canvas, cfg) {
  
  // Properties
  this.canvas   = canvas;
  this.ctx      = canvas.getContext("2d");
  this.matrix   = undefined;
  this.round    = 0;
  
  // Merge of the default and delivered config.
  var defaults = {
      cellsX    : 100,
      cellsY    : 80,
      cellSize  : 10,
      rules     : "23/3",
      gridColor : "#eee",
      cellColor : "darkblue"
  };
  this.cfg = $.extend({}, defaults, cfg);
  
  // Initialize the canvas and matrix.
  this.init();
}

/**
* Prototype of the Game of Life object
* 
* @author Qbit
* @version 0.1
*/
Game.prototype = {
  
  /**
   * Initializes the canvas object and the matrix.
   */
  init: function() {
      // set canvas dimensions
      this.canvas.width  = this.cfg.cellsX * this.cfg.cellSize;
      this.canvas.height = this.cfg.cellsY * this.cfg.cellSize;
      
      // initialize matrix
      this.matrix = new Array(this.cfg.cellsX);
      for (var x = 0; x < this.matrix.length; x++) {
          this.matrix[x] = new Array(this.cfg.cellsY);
          for (var y = 0; y < this.matrix[x].length; y++) {
              this.matrix[x][y] = false;
          }
      }
      
      this.draw();
  },
  
  /**
   * Draws the entire game on the canvas.
   */
  draw: function() {
  var x, y;
      // clear canvas and set colors
      this.canvas.width = this.canvas.width;
      this.ctx.strokeStyle = this.cfg.gridColor;
      this.ctx.fillStyle = this.cfg.cellColor;
      
      // draw grid
      for (x = 0.5; x < this.cfg.cellsX * this.cfg.cellSize; x += this.cfg.cellSize) {
        this.ctx.moveTo(x, 0);
        this.ctx.lineTo(x, this.cfg.cellsY * this.cfg.cellSize);
      }

      for (y = 0.5; y < this.cfg.cellsY * this.cfg.cellSize; y += this.cfg.cellSize) {
        this.ctx.moveTo(0, y);
        this.ctx.lineTo(this.cfg.cellsX * this.cfg.cellSize, y);
      }

      this.ctx.stroke();
      
      // draw matrix
      for (x = 0; x < this.matrix.length; x++) {
          for (y = 0; y < this.matrix[x].length; y++) {
              if (this.matrix[x][y]) {
                  this.ctx.fillRect(x * this.cfg.cellSize + 1,
                                    y * this.cfg.cellSize + 1,
                                    this.cfg.cellSize - 1,
                                    this.cfg.cellSize - 1);
              }
          }
      }
  },
  
  /**
   * Calculates the new state by applying the rules.
   * All changes were made in a buffer matrix and swapped at the end.
   */
  step: function() {
      // initalize buffer
  var x, y;
      var buffer = new Array(this.matrix.length);
      for (x = 0; x < buffer.length; x++) {
          buffer[x] = new Array(this.matrix[x].length);
      }
      
      // calculate one step
      for (x = 0; x < this.matrix.length; x++) {
          for (y = 0; y < this.matrix[x].length; y++) {
              // count neighbours
              var neighbours = this.countNeighbours(x, y);
              
              // use rules
              if (this.matrix[x][y]) {
                  if (neighbours == 2 || neighbours == 3)
                      buffer[x][y] = true;
                  if (neighbours < 2 || neighbours > 3)
                      buffer[x][y] = false;
              } else {
                  if (neighbours == 3)
                      buffer[x][y] = true;
              }
          }
      }
      
      // flip buffers
      this.matrix = buffer;
      this.round++;
      this.draw();
  },
  
  /**
   * Counts the living neighbours of the cell at the given coordinates.
   * A cell can have up to 8 neighbours. Borders are concidered as dead.
   * 
   * @param cx horizontal coordinates of the given cell
   * @param cy vertical coordinates of the given cell
   * @return the number of living neighbours
   */
  countNeighbours: function(cx, cy) {
      var count = 0;
      
      for (var x = cx-1; x <= cx+1; x++) {
          for (var y = cy-1; y <= cy+1; y++) {
              if (x == cx && y == cy)
                  continue;
              if (x < 0 || x >= this.matrix.length || y < 0 || y >= this.matrix[x].length)
                  continue;
              if (this.matrix[x][y])
                  count++;
          }
      }
      
      return count;
  },
  
  /**
   * Clears the entire matrix, by setting all cells to false.
   */
  clear: function() {
      for (var x = 0; x < this.matrix.length; x++) {
          for (var y = 0; y < this.matrix[x].length; y++) {
              this.matrix[x][y] = false;
          }
      }
      
      this.draw();
  },
  
  /**
   * Fills the matrix with a random pattern.
   * The chance that a cell will be alive is at 30%.
   */
  randomize: function() {
      for (var x = 0; x < this.matrix.length; x++) {
          for (var y = 0; y < this.matrix[x].length; y++) {
              this.matrix[x][y] = Math.random() < 0.3;
          }
      }
      
      this.draw();
  },
  
  /**
   * Toggels the state of one cell at the given coordinates.
   *
   * @param cx horizontal coordinates of the given cell
   * @param cy vertical coordinates of the given cell
   */
  toggleCell: function(cx, cy) {
      if (cx >= 0 && cx < this.matrix.length && cy >= 0 && cy < this.matrix[0].length) {
          this.matrix[cx][cy] = !this.matrix[cx][cy];
          this.draw();
      }
  }
};

/* ***** MAIN SCRIPT ***** */

// animation loop
var timer;

// Initialize game
var game = new Game(document.getElementById("game"));

// run or stop the animation loop
$("#run").click(function() {
if (timer === undefined) {
  timer = setInterval(run, 40);
  $(this).text("Stop");
} else {
  clearInterval(timer);
  timer = undefined;
  $(this).text("Start");
}
});

// make a single step in the animation loop
$("#step").click(function() {
if (timer === undefined) {
  game.step();
  $("#round span").text(game.round);
}
});

// make a 23 step in animation loop
$("#step23").click(function() {
if (timer === undefined) {
    for (var x=0; x<=23; x++){
  game.step();
  $("#round span").text(game.round);
    }
}
});

// clear the entire game board
$("#clear").click(function() {
game.clear();
game.round = 0;
$("#round span").text(game.round);
});

// set a random pattern on the game board
$("#rand").click(function() {
game.randomize();
game.round = 0;
$("#round span").text(game.round);
});

// register onclick on the canvas
game.canvas.addEventListener("click", gameOnClick, false);

// determens the click position and toggels the corresponding cell
function gameOnClick(e) {
  var x;
  var y;
  
  // determen click position
  if (e.pageX !== undefined && e.pageY !== undefined) {
      x = e.pageX;
      y = e.pageY;
  } else {
      x = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
      y = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
  }
  
  // make it relativ to canvas
  x -= game.canvas.offsetLeft;
  y -= game.canvas.offsetTop;
  
  // calculate clicked cell
  x = Math.floor(x/game.cfg.cellSize);
  y = Math.floor(y/game.cfg.cellSize);
  
  game.toggleCell(x, y);
}

// runs the animation loop, calculates a new step and updates the counter
function run() {
  game.step();
  $("#round span").text(game.round);
}

game.randomize();
</script>
</html>