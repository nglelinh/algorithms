<?php
use Algorithms\Structure\BinaryTree;
use Algorithms\Node\Tree\BinaryTreeNode;
use Algorithms\Structure\BinarySearchTree;

class BinarySearchTreeTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var BinarySearchTree
     */
    private $binarySearchTree;

    private $values = [
        8,
        5,
        9,
        7,
        1,
        12,
        2,
        10,
        4,
        11,
        3
    ];

    private $sortedValues = [
        1,
        2,
        3,
        4,
        5,
        7,
        8,
        9,
        10,
        11,
        12
    ];

    public function setup()
    {
        $this->binarySearchTree = new BinarySearchTree();
        foreach ($this->values as $value) {
            $this->binarySearchTree->insert($value);
        }
    }

    public function testGetRoot()
    {
        self::assertEquals(8, $this->binarySearchTree->getRoot()->getData());
    }

    public function testSortTree()
    {
        // Sorts!
        self::assertEquals($this->sortedValues, $this->binarySearchTree->inOrder());
    }

    public function testSearchFound()
    {
        self::assertFalse($this->binarySearchTree->search(18));
        self::assertInstanceOf(BinaryTreeNode::class, $this->binarySearchTree->search(8));
    }

    public function testAddNode()
    {
        $this->binarySearchTree = new BinarySearchTree();
        foreach ($this->values as $value) {
            self::assertTrue($this->binarySearchTree->insert($value));
        }
        $node = $this->binarySearchTree->getRoot()->getRight()->getRight();
        self::assertEquals(12, $node->getData());
        $node = $this->binarySearchTree->getRoot()->getLeft()->getRight();
        self::assertEquals(7, $node->getData());
        $node = $this->binarySearchTree->getRoot()->getLeft()->getLeft()->getRight();
        self::assertEquals(2, $node->getData());
        $node = $node->getRight()->getLeft();
        self::assertEquals(3, $node->getData());
    }

    public function testDeleteOneNodeEmpty()
    {
        $this->binarySearchTree->deleteValue(4);
        $values = [
            1,
            2,
            3,
            5,
            7,
            8,
            9,
            10,
            11,
            12
        ];
        self::assertEquals($values, $this->binarySearchTree->inOrder());
    }

    public function testDeleteTwoNodeEmpty()
    {
        $this->binarySearchTree->deleteValue(7);
        $values = [
            1,
            2,
            3,
            4,
            5,
            8,
            9,
            10,
            11,
            12
        ];
        self::assertEquals($values, $this->binarySearchTree->inOrder());
    }

    public function testDeleteNoNodeEmpty()
    {
        $this->binarySearchTree->deleteValue(5);
        $values = [
            1,
            2,
            3,
            4,
            8,
            9,
            10,
            11,
            12
        ];
        self::assertEquals($values, $this->binarySearchTree->inOrder());
    }

    public function testSearchNotFound()
    {
        self::assertFalse($this->binarySearchTree->search(36));
    }

    public function testBreadthFirst()
    {
        $breadthFirst = [
            8,
            5,
            9,
            1,
            7,
            12,
            2,
            10,
            4,
            11,
            3
        ];
        self::assertEquals($breadthFirst, $this->binarySearchTree->breadthFirst());
    }

    public function testMax()
    {
        self::assertEquals(12, $this->binarySearchTree->max()->getData());
    }

    public function testPredecessor()
    {
        $node        = $this->binarySearchTree->getRoot()->getRight()->getRight(); //12
        $predecessor = $this->binarySearchTree->predecessor($node);
        self::assertInstanceOf(BinaryTreeNode::class, $predecessor);
        self::assertEquals(11, $predecessor->getData());

        $node        = $this->binarySearchTree->getRoot()->getLeft()->getRight(); //7
        $predecessor = $this->binarySearchTree->predecessor($node);
        self::assertInstanceOf(BinaryTreeNode::class, $predecessor);
        self::assertEquals(5, $predecessor->getData());

        $node        = $this->binarySearchTree->getRoot()->getLeft()->getLeft()->getRight()->getRight(); //4
        $predecessor = $this->binarySearchTree->predecessor($node);
        self::assertInstanceOf(BinaryTreeNode::class, $predecessor);
        self::assertEquals(3, $predecessor->getData());

        $node        = $this->binarySearchTree->getRoot()->getLeft()->getLeft(); //1
        $predecessor = $this->binarySearchTree->predecessor($node);
        self::assertEquals(false, $predecessor);
    }

    public function testSuccessor()
    {
        $node        = $this->binarySearchTree->getRoot()->getRight()->getRight(); //12
        $predecessor = $this->binarySearchTree->successor($node);
        self::assertEquals(false, $predecessor);

        $node        = $this->binarySearchTree->getRoot()->getLeft()->getRight(); //7
        $predecessor = $this->binarySearchTree->successor($node);
        self::assertInstanceOf(BinaryTreeNode::class, $predecessor);
        self::assertEquals(8, $predecessor->getData());

        $node        = $this->binarySearchTree->getRoot()->getLeft()->getLeft()->getRight()->getRight(); //4
        $predecessor = $this->binarySearchTree->successor($node);
        self::assertInstanceOf(BinaryTreeNode::class, $predecessor);
        self::assertEquals(5, $predecessor->getData());
    }

    public function testDeleteLeaf()
    {
        $node = $this->binarySearchTree->getRoot()->getLeft()->getRight(); //7
        $this->binarySearchTree->delete($node);

        $node = $this->binarySearchTree->getRoot()->getLeft()->getRight(); //7
        self::assertNull($node);
    }

    public function testDeleteHalfNode()
    {
        $node = $this->binarySearchTree->getRoot()->getRight()->getRight(); //12
        $this->binarySearchTree->delete($node);
        $node = $this->binarySearchTree->getRoot()->getRight(); //9
        self::assertInstanceOf(BinaryTreeNode::class, $node);
        self::assertEquals(9, $node->getData());
        $node = $this->binarySearchTree->getRoot()->getRight()->getRight(); //10
        self::assertInstanceOf(BinaryTreeNode::class, $node);
        self::assertEquals(10, $node->getData());
        self::assertEquals(9, $node->getParent()->getData());
    }

    public function testDeleteFullNode()
    {
        $node = $this->binarySearchTree->getRoot()->getLeft();
        $this->binarySearchTree->delete($node);

        $node = $this->binarySearchTree->getRoot()->getLeft();
        self::assertInstanceOf(BinaryTreeNode::class, $node);
        self::assertEquals(4, $node->getData());

        self::assertEquals(7, $node->getRight()->getData());
        self::assertEquals(1, $node->getLeft()->getData());
        self::assertEquals(3, $node->getLeft()->getRight()->getRight()->getData());
    }

    public function testSearchDepthFirstPreOrder()
    {
        $expected = [8, 5, 1, 2, 4, 3, 7, 9, 12, 10, 11];
        $result   = $this->binarySearchTree->depthFirst(BinaryTree::SEARCH_PRE_ORDER);
        self::assertEquals($expected, $result);
        self::assertEquals($expected, $this->binarySearchTree->preOrder());
    }

    public function testSearchDepthFirstInOrder()
    {
        $expected = [1, 2, 3, 4, 5, 7, 8, 9, 10, 11, 12];
        $result   = $this->binarySearchTree->depthFirst(BinaryTree::SEARCH_IN_ORDER);
        self::assertEquals($expected, $result);
        self::assertEquals($expected, $this->binarySearchTree->inOrder());
    }

    public function testSearchDepthFirstPostOrder()
    {
        $expected = [3, 4, 2, 1, 7, 5, 11, 10, 12, 9, 8];
        $result   = $this->binarySearchTree->depthFirst(BinaryTree::SEARCH_POST_ORDER);
        self::assertEquals($expected, $result);
        self::assertEquals($expected, $this->binarySearchTree->postOrder());
    }

    public function testValidateTree()
    {
        self::assertTrue($this->binarySearchTree->validate($this->binarySearchTree->getRoot()));
    }

    public function testHeight()
    {
        self::assertEquals(6, $this->binarySearchTree->calculateHeight());
    }
}
