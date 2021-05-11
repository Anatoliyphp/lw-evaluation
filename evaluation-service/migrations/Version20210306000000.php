<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210306000000 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Adds course, lab_work and task test data';
    }

    public function up(Schema $schema) : void
    {
         $this->addSql('
            INSERT INTO
                `course` (id, title, description)
            VALUES 
                (1, "Основы программирования", "Курс по основам программирования на языке Pascal"),
                (2, "Основы программирования-2", "Курс по основам программирования на языке Pascal-2")
         ');
        
        $this->addSql('
            INSERT INTO
                `lab_work`(id, title, course_id)
            VALUES 
                (
                    DEFAULT,
                    "Лабораторная работа 1",
                    (SELECT id FROM course WHERE title = "Основы программирования")
                ),
                (
                    DEFAULT, 
                    "Лабораторная работа 2",
                    (SELECT id FROM course WHERE title = "Основы программирования")
                ),
                (
                    DEFAULT,
                    "Лабораторная работа 1",
                    (SELECT id FROM course WHERE title = "Основы программирования-2")
                ),
                (
                    DEFAULT, 
                    "Лабораторная работа 2",
                    (SELECT id FROM course WHERE title = "Основы программирования-2")
                )
        ');

        $this->addSql('
            INSERT INTO
                `task`(id, title, description, passing_score, max_score, pipeline_id, lab_work_id)
            VALUES 
                (
                    DEFAULT,
                    "1.1.1. [#5]",
                    "Для следующих программ дайте имя, разместите правильно текст, исправив ошибки форматирования, оттранслируйте и определите выход (OUTPUT):
                    a)
                    PROGRAM .....(INPUT,OUTPUT); BEGIN
                    WRITELN(\'GOODBYE\')
                    END.
                    b)
                    PROGRAM .......(INPUT,OUTPUT); BEGIN
                    WRITELN(\'Santa Claus\')
                    END.
                    с)
                    PROGRAM ....(INPUT,OUTPUT); BEGIN
                    WRITELN(\'ЛАДА\')
                    END.",
                    5,
                    5,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 1" AND course_id = 1)
                ),
                (
                    DEFAULT,
                    "1.1.2. [#5]",
                    "Следующие программы разместите по строкам, сделайте отступы, отформатируйте код. Оттранслируйте и определите выход (OUTPUT):
                    a) PROGRAM MOUSE(INPUT,OUTPUT); BEGIN WRITELN (\'Little Mouse, little Mouse, where is your house?\') END.
                    b) PROGRAM ANGELS (INPUT,OUTPUT); BEGIN WRITELN
                    (\'ANGELS CAN BE HEARD ON HIGH\') END.
                    c) PROGRAM QUESTION(INPUT, OUTPUT); BEGIN WRITELN(\'ISN\'\'T THIS EASY?\')
                    END.
                    Кавычка, повторяемая 2 раза внутри строки, служит для представления одинарной кавычки.",
                    5,
                    5,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 1" AND course_id = 1)
                ),
                (
                    DEFAULT,
                    "1.2.1. [#5]",
                    "Следующие программы разместите по строкам, сделайте отступы, отформатируйте код. Оттранслируйте и определите выход (OUTPUT):
                    a) PROGRAM Poem (INPUT,OUTPUT); BEGIN WRITE (\'ROSES ARE \');WRITELN(\'RED,\'); WRITE(\'VIOL\');WRITE(\'ETS ARE\');WRITELN (\' BLUE, \');WRITE(\'OTHERS CAN PR\');WRITELN (\'OGRAM,\'); WRITE(\'SO CAN\');WRITELN(\' YOU. \') END.
                    b) PROGRAM Pattern1 (INPUT,OUTPUT);BEGIN WRITE (\' *\'); WRITELN; WRITELN (\' * *\');WRITELN (\'* *\'); WRITE (\' * *\');WRITELN;WRITELN (\' *\') END.
                    Программа Pattern1 выводит ромбик с помощью символов \'*\'.",
                    5,
                    5,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 1" AND course_id = 1)
                ),
                (
                    DEFAULT,
                    "2.1. [#10]",
                    "Определите таблицу выполнения для программы:
                    PROGRAM Copy2(INPUT, OUTPUT);
                    {Копирует первые два символа из INPUT в OUTPUT}
                    VAR
                    Letter: CHAR;
                    BEGIN
                    READ(Letter);
                    WRITE(Letter);
                    READ(Letter);
                    WRITELN(Letter)
                    END.
                    Выполнение
                    INPUT : AZURE
                    OUTPUT: AZ",
                    5,
                    10,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 2" AND course_id = 1)
                ),
                (
                    DEFAULT,
                    "2.2.1. [#10]",
                    "Следующую программу разместите по строкам, сделайте отступы, отформатируйте.
                    Оттранслируйте и определите выход (OUTPUT) для INPUT: BOB
                    PROGRAM Dup(INPUT,OUTPUT);VAR Ch1,
                    Ch2,Ch3:CHAR;BEGIN READ(Ch1,Ch2,
                    Ch3);IF Ch1 = Ch2 THEN WRITE(Ch1,
                    Ch2,\' \');IF Ch1 = Ch3 THEN WRITE
                    (Ch1,Ch3,\' \'); IF Ch2 = Ch3 THEN
                    WRITE(Ch2,Ch3);WRITELN END.",
                    5,
                    10,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 2" AND course_id = 1)
                ),
                (
                    DEFAULT,
                    "2.2.2. [#10]",
                    "Следующую программу разместите по строкам, сделайте отступы, отформатируйте. Дополните эхом ввода.
                    Оттранслируйте и определите выход (OUTPUT) для
                    INPUT:5
                    INPUT:A5
                    PROGRAM What INPUT OUTPUT VAR Ch CHAR
                    BEGIN READ Ch IF \'0\' <= Ch THEN IF Ch
                    <= \'9\' THEN WRITELN YES ELSE WRITELN NO
                    ELSE WRITELN NO END",
                    5,
                    10,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 2" AND course_id = 1)
                ), 
                (
                    DEFAULT,
                    "1.1. [#20]",
                    "Следующую программу разместите по строкам, сделайте отступы, отформатируйте. Дополните аннотированным выходом.
                    Оттранслируйте и определите выход (OUTPUT):
                    PROGRAM Less INPUT OUTPUT VAR Ch
                    CHAR BEGIN READ Ch WHILE
                    Ch <> \'#\' DO BEGIN IF Ch<> \' \' THEN WRITE
                    Ch READ Ch END WRITELN END
                    INPUT:HI OUT THERE#...",
                    15,
                    20,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 1" AND course_id = 2)
                ),
                (
                    DEFAULT,
                    "1.2. [#30]",
                    "Определите таблицу выполнения для программы CopyOdd.
                    INPUT:AZ#
                    PROGRAM CopyOdds(INPUT, OUTPUT);
                    {Копирует через один символы из INPUT в OUTPUT,
                    но до тех пор, пока не встретится первое #.}
                    VAR Ch, Next: CHAR;
                    {Next - это переключатель между нечетными (odd (O))
                    и четными (even (E)}
                    BEGIN
                    Next := \'O\'; {odd}
                    READ(Ch);
                    WHILE Ch <> \'#\'
                    DO
                    BEGIN
                    IF Next = \'O\'
                    THEN {Копирование нечетных символов}
                    WRITE(Ch);
                    READ(Ch);
                    {Переключение величины Next}
                    IF Next = \'O\'
                    THEN
                    Next := \'E\' {even}
                    ELSE
                    Next := \'O\' {odd}
                    END;
                    WRITELN
                    END.",
                    20,
                    30,
                    1,
                    (SELECT id FROM lab_work WHERE title = "Лабораторная работа 2" AND course_id = 2)
                )   
        ');
    }

    public function down(Schema $schema) : void
    {
        // do nothing
    }
}
