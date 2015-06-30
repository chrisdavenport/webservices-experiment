An experiment in resources, representations, profiles and types.

This is an attempt to explore the relationship between resources, representations, and profiles
in a REST API.  The basic idea is that resource structure is relatively stable compared with
representations.  In the REST world there is no consensus on representation standards and new
representation formats are being introduced regularly.  Consequently, this design encapsulates
the representation in a way that allows it to be easily replaced or extended with a new format
by simply writing a single new class.  You can find the representation classes in the
representation directory.

Bear in mind that this is very crude code.  It's pure PHP, it doesn't use Joomla, it doesn't
use Composer, it doesn't even use autoloading or namespaces.  It's really, really basic.
But hopefully there is just enough structure to prove that it will work when coded "properly".

The design has been strongly influenced by asking the question "Where is change expected?".
The answer is the following list, ordered from most frequent change to least frequent change:-
 1. Addition of new profiles (eg. for a new content type).
 2. Addition of new data types (eg. for custom enumerated types).
 3. Addition of new representation formats (eg. Uber, Siren).
 4. Addition of new media types (eg. JSON, XML).
 5. Addition of new resource structures (eg. item, list).

A central role is played by resource objects.  A resource object can be thought of as an
in-memory representation of something, such as data from a database, or some application
state.  The structure of the data contained in the resource object is defined by a profile.
A resource will be one of only a small number of types, described below.  New resource
types could be added, but new methods to handle the new resource type would need to be added to
each of the representation classes.  What is more likely to change in the system are the
representation formats and the profiles, so they have been encapsulated separately, leaving
the resource classes with only a coordinating responsibility which is less likely to be
affected by change.

Resource types:
  Top level resource types:
    ResourceItem     models a single "item".
    ResourceList     models a collection of items.

  Mid level resource types:
    ResourceMetadata models metadata associated with a resource.
    ResourceData     models data contained in a resource.
    ResourceLinks    models transitions to other resource states.
    ResourceEmbedded models resources associated with a resource.

  Primitive resource types:
    ResourceProperty models a simple name-value pair. - So simple I didn't actually implement it!
    ResourceLink     models a single transition to another resource state.
    ResourceCurie    models a compact URI, known as a "Curie".

Profiles are like schemas and define a kind of template which is used to construct a resource
object in memory.  A representation is then derived from the resource object.  A profile
defines the name and type of each property and could be extended with other information.
An automatic process could be written to generate machine-readable profile documents from
the profile files for public consumption in formats such as ALPS or JSON-LD contexts.

New primitive data types can be added by adding a class file in the type directory.  The new
type can then be referenced in the profile.  The type class is responsible for validating the
internal and external values of a property of that type and for transforming internal values
to external values and vice versa.  In most cases the external representation of a type will be
independent of the representation format, but if there are instances where a particular
representation format requires a different external representation of a type, it can be
overridden in the representation class.

A representation is a serialisation of the resource as a set of external values in some
external format, such as hal+json, uber, siren, etc.  Conversely, it also allows for the parsing
of an incoming serialisation into a resource object using a profile as a guide.

Enjoy!

Chris.

@TODO Add support for ResourceList.


