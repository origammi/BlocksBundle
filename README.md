# Origammi Blocks Bundle

[![Build Status](https://travis-ci.org/origammi/BlocksBundle.svg?branch=master)](https://travis-ci.org/origammi/BlocksBundle)


## Usage

### Requirements

* PHP 5.4+

### Register bundle

```php
<?php
// app/AppKernel.php

public function registerBundles()
{
    $bundles = array(
        // ...
        new Origammi\Bundle\BlocksBundle\OrigammiBlocksBundle($this),
        new Infinite\FormBundle\InfiniteFormBundle,
        // ...
    );
}
```

### Prepare entity

```php
<?php

namespace AppBundle\Entity;

use Origammi\Bundle\BlocksBundle\Annotation as Origammi;
use Origammi\Bundle\BlocksBundle\Entity\BlockCollection;

class Post
{
    // ...
    /**
     * @var BlockCollection
     *
     * @ORM\ManyToOne(targetEntity="Origammi\Bundle\BlocksBundle\Entity\BlockCollection", cascade={"remove", "persist"})
     * @Origammi\BlockCollectionData(
     *  allowed={"lead", "text", "quote"},
     *  required={"lead"}
     * )
     */
    private $blocks;

    /**
     * @var BlockCollection
     *
     * @ORM\ManyToOne(targetEntity="Origammi\Bundle\BlocksBundle\Entity\BlockCollection", cascade={"remove", "persist"})
     * @Origammi\BlockCollectionData(
     *  allowed={"text"},
     *  required={"text"}
     * )
     */
    private $sidebarBlocks;
    
    // ...
    
    
    /**
     * @return BlockCollection
     */
    public function getBlocks()
    {
        return $this->blocks;
    }

    /**
     * @param BlockCollection $blocks
     *
     * @return $this
     */
    public function setBlocks(BlockCollection $blocks)
    {
        $this->blocks = $blocks;

        return $this;
    }

    /**
     * @return BlockCollection
     */
    public function getSidebarBlocks()
    {
        return $this->sidebarBlocks;
    }

    /**
     * @param BlockCollection $blocks
     *
     * @return $this
     */
    public function setSidebarBlocks(BlockCollection $blocks)
    {
        $this->sidebarBlocks = $blocks;

        return $this;
    }

}

```

### Create form

```php
<?php

$form = $this
            ->createFormBuilder($post)
            ->add('blocks', 'origammi_blocks')
            ->add('sidebarBlocks', 'origammi_blocks')
            ->getForm();

```

### Assets (optional)

In case you are using Admin LTE2, be sure to load assets in your layout.

```
<script type="text/javascript" src="{{ asset('bundles/origammiblocks/js/main.js') }}"></script>
```

```
'bundles/origammiblocks/css/admin-lte2.css'
```
