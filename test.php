<?php
/**
 * This is an attempt to explore the relationship between resources, representations, and profiles
 * in a REST API.  The basic idea is that resource structure is relatively stable compared with
 * representations.  In the REST world there is no consensus on representation standards and new
 * representation formats are being introduced regularly.  Consequently, this design encapsulates
 * the representation in a way that allows it to be easily replaced or extended with a new format
 * by simply writing a single new class.  You can find the representation classes in the
 * representation directory.
 *
 * Bear in mind that this is very crude code.  It's pure PHP, it doesn't use Joomla, it doesn't
 * use Composer, it doesn't even use autoloading or namespaces.  It's really, really basic.
 * But hopefully there is just enough structure to prove that it will work when coded "properly".
 *
 * See README.txt for more information.
 */
require_once 'resource.php';
require_once 'resource/item.php';
require_once 'resource/data.php';
require_once 'resource/metadata.php';
require_once 'resource/link.php';
require_once 'resource/links.php';
require_once 'resource/curie.php';
require_once 'resource/embedded.php';

require_once 'representationinterface.php';
require_once 'representation.php';
require_once 'representation/haljson.php';
require_once 'representation/halxml.php';

require_once 'profile.php';

require_once 'type/integer.php';
require_once 'type/string.php';
require_once 'type/ynglobal.php';
require_once 'type/state.php';

// Instantiate a profile.
// The profile is here defined using a trivially simple json file,
// but in practice it would be defined in a more complex XML file,
// like the contact-1.0.0.xml in redCore.
$profile = new Profile('profile/contact.json');

/**
 * Example 1.  Build a resource object by binding some internal data to it
 * and then generating a couple of different external representations.
 */

// Create some data.
$data = array(
	'name' => 'Chris Davenport',
	'address' => 'Shrewsbury',
	'size' => 10,
	'show' => '1',
	'notused' => 23,	// This item is not in the profile, so it will be ignored.
	'currentlyProcessing' => 14,
	'shippedToday' => 20,
);

// Instantiate a resource with a profile and add some data to it.
$resource = new ResourceItem($profile);
$resource->addData($data);

// Add some more data.
$resource->addData(array('state' => '1'));

// Add some metadata.  Can be anything as it's not checked against the profile.
$resource->addMetadata(array('date' => date('Y-m-d H:i:s')));

// Add some links.
$links = array(
	'self' => new ResourceLink('/orders'),
	'next' => new ResourceLink('/orders?page=2'),
	'ea:find' => new ResourceLink('/orders{?id}', true),
	'ea:admin' => array(
		new ResourceLink('/admins/2', false, 'Fred'),
		new ResourceLink('/admins/5', false, 'Kate'),
	),
);
$resource->addLinks($links);

// Add some curies.
$curies = array(
	new ResourceCurie('ea', 'http://example.com/docs/rels/{rel}', true),
	new ResourceCurie('joomla', 'http://docs.joomla.org/rels/{rel}', true),
);
$resource->addCuries($curies);

// Now create a resource that will be embedded in the main resource.
$embeddedResource = new ResourceItem(new Profile('profile/order.json'));
$embeddedResource
	->addData(array('total' => '30.00', 'currency' => 'USD', 'status' => 'shipped'))
	->addLinks(array(
		'self' => new ResourceLink('/orders/123'),
		'ea:basket' => new ResourceLink('/baskets/98712'),
		'ea:customer' => new ResourceLink('/customers/7809'),
		))
	;

// Embed the resource into the main resource.
$resource->addEmbedded(array('ea:order' => $embeddedResource));

// And create another resource that will be embedded in the main resource.
$embeddedResource = new ResourceItem(new Profile('profile/order.json'));
$embeddedResource
	->addData(array('total' => '20.00', 'currency' => 'USD', 'status' => 'processing'))
	->addLinks(array(
		'self' => new ResourceLink('/orders/124'),
		'ea:basket' => new ResourceLink('/baskets/97213'),
		'ea:customer' => new ResourceLink('/customers/12369')
		))
	;

// Embed the resource into the main resource.
$resource->addEmbedded(array('ea:order' => $embeddedResource));

// Get the data back out.
print_r($resource->getInternalData());

// Generate a hal+json representation of the resource.
// Well, not really HAL, but that's the idea.
$representation = new RepresentationHalJson;
$json = $representation->render($resource);
echo 'Representation as application/hal+json' . "\n";
echo $json . "\n";

// Generate a hal+xml representation of the resource.
// Again, not really HAL, but the idea is there.
$representation = new RepresentationHalXml;
$xml = $representation->render($resource);
echo "\n";
echo 'Representation as application/hal+xml' . "\n";
echo $xml . "\n";

/**
 * Example 2: Build a resource object by parsing an external representation
 * and then getting the data out in its internal format.
 */

// Start by creating a new, empty, resource.
$resource = new ResourceItem($profile);

// Show that it's empty.
print_r($resource->getData());

// Parse an external representation.
$data = array(
	'name' => 'Chris Davenport',
	'address' => 'Shrewsbury',
	'size' => 10,
	'show' => 'yes',
	'notused' => 23,	// This item is not in the profile, so it will be ignored.
	'state' => 'trashed',
);
$representation = new RepresentationHalJson;
$representation->build($resource, json_encode($data));

// Pull the internal data out.  Note that the properties have been transformed.
print_r($resource->getInternalData());

// That's all folks!

