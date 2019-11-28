<br>
1. Придумать класс, который описывает любую сущность 
из предметной области интернет-магазинов: продукт, ценник, посылка и т.п.
<br>
<?
	class Messages {
		/* 
		*	Приватные свойства
		*/
		private $from;
		private $to;
		private $strHeader;
		private $strBody;
		
		/* 
		*	Конструктор сообщения
		*/
		function __construct($from, $to, $strHeader, $strBody) {
			$this->from = $from;
			$this->to = $to;
			$this->strHeader = $strHeader;
			$this->strBody = $strBody;
		}
		
		/* 
		*	Метод отправляет сообщение
		*/
		public function send() {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.example.com/api/v1/");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
				'from' => $this->from,
				'to' => $this->to,
				'header' => $this->strHeader,
				'body' => $this->strBody,
			]));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$server_output = curl_exec($ch);
			curl_close ($ch);
			if ($server_output == "OK") { 
				echo "Сообщение отправлено !<br>";
			} else { 
				echo "Ошибка при отправлении !<br>";
			}
		}
		
		/* 
		*	Метод демонстрирует сообщение
		*/
		public function display() {
			echo "Сообщение от: ". $this->from .'<br>';
			echo "Сообщение для: ". $this->to .'<br>';
			echo "<h1>". $this->strHeader ."</h1>";
			echo "<p>". $this->strBody ."</p>";
		}
	}
	
	$message = new Messages('Петя', 'Маша', 'Здравствуй !', 'Изучаю ООП, а ты там как ?');
	$message->display();
	$message->send();
?>
<hr>
2. Описать свойства класса из п.1 (состояние).
<hr>
3. Описать поведение класса из п.1 (методы).
<hr>
4. Придумать наследников класса из п.1. Чем они будут отличаться?<br>
<?
	class PaperMail extends Messages {
		/* 
		*	Приватные свойства
		*/
		private $address;
		private $backAddress;
		
		/* 
		*	Конструктор сообщения
		*/
		function __construct($from, $to, $strHeader, $strBody, $address, $backAddress) {
			parent::__construct($from, $to, $strHeader, $strBody);
			
			$this->address 		= $address;
			$this->backAddress 	= $backAddress;
		}
		
		/* 
		*	Метод отправляет сообщение
		*/
		public function display() {
			echo "Сообщение от: ". $this->from .'<br>';
			echo "На адрес: ". $this->address .'<br>';
			echo "Сообщение для: ". $this->to .'<br>';
			echo "Обратный: ". $this->backAddress .'<br>';
			echo "<h1>". $this->strHeader ."</h1>";
			echo "<p>". $this->strBody ."</p>";
		}
		
		/* 
		*	Метод отправляет сообщение
		*/
		public function send() {
			echo "Печатаем письмо, несём на почту.<br>";
		}
	}
	
	$message = new PaperMail('Петя', 'Маша', 'Здравствуй !', 'Изучаю ООП, а ты там как ?', 'Москва', 'Уфа');
	$message->display();
	$message->send();
?>
<hr>
5. Дан код:
<pre>
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
$a1 = new A();
$a2 = new A();
$a1->foo();
$a2->foo();
$a1->foo();
$a2->foo();
</pre>
<hr>
Что он выведет на каждом шаге? Почему?
<br>
<i>
Код выведет:
<code>
	1234
</code>
Переменная $x статична и пиринадлежит классу A, а не его экзеплярам.
Static внутри функции будет проинициализирована 
только при первом вызове функции, но при каждом вызове будет интерирована.
</i>
<br>

Немного изменим п.5:
<pre>

class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class B extends A {}
$a1 = new A();
$b1 = new B();
$a1->foo(); 
$b1->foo(); 
$a1->foo(); 
$b1->foo();

</pre>
6. Объясните результаты в этом случае.
<br>
<i>
Код выведет:
<code>
	1122
</code>
Переменная $x статична и пиринадлежит классу A и B, а не его экзеплярам. 
Значит в памяти 2 статических переменных $x. Каждая интерируется при вызове своего метода класса.
</i>
<br>

<hr>
7. *Дан код:
<pre>
class A {
    public function foo() {
        static $x = 0;
        echo ++$x;
    }
}
class B extends A {}
$a1 = new A;
$b1 = new B;
$a1->foo(); 
$b1->foo(); 
$a1->foo(); 
$b1->foo(); 
</pre>
Что он выведет на каждом шаге? Почему?<br>
<i>
Код выведет:
<code>
	1122
</code>
<br>
<b>Код совпадает с кодом задания п.5</b>
Объявлен класс A<br>
Объявлен метод foo()<br>
Наследован класс B от А<br>
Объявлен переменная $a1 и присвоен ей экземпляр класса A<br>
Объявлен переменная $b1 и присвоен ей экземпляр класса В<br>
Вызван метод foo() экземпляра класса A через переменную $a1<br>
В методе foo() экземпляра класса A, проинициализирована переменая $x со значением 0<br>
$x проинтерированна до 1<br>
$x отправлена в буффер вывода<br>
В методе foo() экземпляра класса B, проинициализирована переменая $x со значением 0<br>
$x проинтерированна до 1<br>
$x отправлена в буффер вывода<br>
Вызван метод foo() экземпляра класса A через переменную $a1<br>
$x проинтерированна до 1<br>
$x отправлена в буффер вывода<br>
Вызван метод foo() экземпляра класса A через переменную $a1<br>
$x проинтерированна до 1<br>
$x отправлена в буффер вывода<br>
</i>