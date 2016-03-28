<?php
namespace Doctrine\Tools;

use Doctrine\ORM\Query\AST\Functions\FunctionNode;
use Doctrine\ORM\Query\Lexer;
use Doctrine\ORM\Query\Parser;
use Doctrine\ORM\Query\QueryException;
use Doctrine\ORM\Query\SqlWalker;

class Random extends FunctionNode
{
    /**
     * @param Parser $parser
     */
    public function parse(Parser $parser)
    {
        $parser->match(Lexer::T_IDENTIFIER);
        $parser->match(Lexer::T_OPEN_PARENTHESIS);
        $parser->match(Lexer::T_CLOSE_PARENTHESIS);
    }

    /**
     * @param  SqlWalker $sqlWalker
     * @return string
     * @throws QueryException
     */
    public function getSql(SqlWalker $sqlWalker)
    {
        switch ($sqlWalker->getConnection()->getDatabasePlatform()->getName()) {
            case 'postgresql':
                return 'RANDOM()';
                break;
            case 'mysql':
                return 'RAND()';
                break;
            default:
                throw new QueryException("You can't use RANDOM()!");
        }
    }
}
