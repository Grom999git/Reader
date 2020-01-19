<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ReaderController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){
    	

    	//Сохраняем ленту в объект;
    	$object = simplexml_load_file('https://www.theregister.co.uk/software/headlines.atom');
    	//Собираем данные для оформления ленты
    	$rss;
    	$rss['title'] = $object->title[0];
    	$rss['logo'] = $object->logo;
    	$link = get_object_vars($object)['link'][1];
    	$rss['link'] = get_object_vars($link)['@attributes']['href'];

    	//Преобразовываем в массив
    	$array = get_object_vars($object);
    	//Получаем список новостей
    	$news = $array['entry'];
    	//Создаем строку из всех слов
    	$words_string = '';
    	//Заполняем значениями из title и summary
    	for($i=0; $i<count($news); $i++) {
    		$words_string .= $news[$i]->title .= ' ';
    		$words_string .= $news[$i]->summary .= ' ';
    	}
    	//Удаляем теги и приводим к нижнему регистру
    	$no_tags_string = strtolower(strip_tags($words_string));
    	//Удаляем ненужные символы
    	$no_tags_string = preg_replace ("/[^a-zа-я\s]/"," ",$no_tags_string);
    	//Создаем массив из всех слов
    	$words_array = str_word_count($no_tags_string, 1);  	
    	//Список из 100 ходовых слов
    	$common = str_word_count('"the","of","and","a","to","in","is","you","that","it","he","was","for","on","are","as","with","his","they","I","at","be","this","have","from","or","one","had","by","word","but","not","what","all","were","we","when","your","can","said","there","use","an","each","which","she","do","how","their","if","will","up","other","about","out","many","then","them","these","so","some","her","would","make","like","him","into","time","has","look","two","more","write","go","see","number","no","way","could","people","my","than","first","water","been","call","who","oil","its","now","find","long","down","day","did","get","come","made","may","part"', 1);
    	//Создаем массив из слов ключ = слово => значение = колличество слов в масссиве 
    	$array = [];
    	//Заполняем массив
    	for($i=0; $i<count($words_array); $i++){
    		$word = $words_array[$i];

    		$counter = 0;
    		foreach ($words_array as $key => $value) {
    			if($value == $word){
    				$counter +=1;
    			}
    		}
    		$array[$word] = $counter;
    	}
    	//Отфильтровываем слова меньше 3-х символов
    	$wordlen = 4;
    	foreach($array as $key => $value){
			if(strlen($key) < $wordlen) {
				unset($array[$key]);
			}
		}
    	//Отфильтровываем популярные слова
    	foreach ($common as $key => $value) {
    		if(array_key_exists($value, $array)){
    			unset($array[$value]);
    		}
    	}
    	//сортируем по уменьшению колличества
    	arsort($array);
    	//Берем 10 элементов
    	$array = array_slice($array, 0, 10);
        //Делаем удобный массив
    	$news_array = [];
    	for ($i = 0; $i < count($news); $i++) {
    		$news_array[$i]['title'] = $news[$i]->title;
    		$news_array[$i]['summary'] = $news[$i]->summary;
    		$link = get_object_vars($news[$i])['link'][0];
    		$news_array[$i]['link'] = get_object_vars($link)['@attributes']['href'];
    	}

    	return view('reader.index', compact('array', 'rss', 'news_array'));
    }
}
