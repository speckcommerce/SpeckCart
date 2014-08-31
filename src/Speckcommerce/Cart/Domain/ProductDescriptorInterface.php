<?php
/**
 * SpeckCommerce (http://speckcommerce.com)
 *
 * @link      http://github.com/speckcommerce/SpeckCart for the canonical source repository
 * @copyright Copyright (c) 2010-2014 Roave, LLC.
 * @license   http://www.opensource.org/licenses/bsd-license.php BSD License
 */

namespace Speckcommerce\Cart\Domain;

/**
 * Product descriptor responsible for tracking related product
 *
 * Descriptor implementation will vary by use case. It can simply track
 * productId in one implementation or hold all required information for complex
 * multioption products in another in another
 *
 * This interface will define interface required for basic cart operation,
 * while more specific handlers can perform additional operations where appropriate
 *
 */
interface ProductDescriptorInterface
{

}
