<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2014 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace Speckcommerce\Cart\Domain;

use Rhumsaa\Uuid\Uuid;

class CartItemId
{
    protected $uuid;

    public function __construct(Uuid $uuid)
    {
        $this->uuid = $uuid;
    }

    public function __toString()
    {
        return $this->uuid->toString();
    }

    public static function fromString($uuid)
    {
        return new static(Uuid::fromString($id));
    }
}
