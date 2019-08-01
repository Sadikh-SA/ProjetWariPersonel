<?php

namespace Proxies\__CG__\App\Entity;

/**
 * DO NOT EDIT THIS FILE - IT WAS CREATED BY DOCTRINE'S PROXY GENERATOR
 */
class Partenaire extends \App\Entity\Partenaire implements \Doctrine\ORM\Proxy\Proxy
{
    /**
     * @var \Closure the callback responsible for loading properties in the proxy object. This callback is called with
     *      three parameters, being respectively the proxy object to be initialized, the method that triggered the
     *      initialization process and an array of ordered parameters that were passed to that method.
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setInitializer
     */
    public $__initializer__;

    /**
     * @var \Closure the callback responsible of loading properties that need to be copied in the cloned object
     *
     * @see \Doctrine\Common\Persistence\Proxy::__setCloner
     */
    public $__cloner__;

    /**
     * @var boolean flag indicating if this object was already initialized
     *
     * @see \Doctrine\Common\Persistence\Proxy::__isInitialized
     */
    public $__isInitialized__ = false;

    /**
     * @var array properties to be lazy loaded, with keys being the property
     *            names and values being their default values
     *
     * @see \Doctrine\Common\Persistence\Proxy::__getLazyProperties
     */
    public static $lazyPropertiesDefaults = [];



    /**
     * @param \Closure $initializer
     * @param \Closure $cloner
     */
    public function __construct($initializer = null, $cloner = null)
    {

        $this->__initializer__ = $initializer;
        $this->__cloner__      = $cloner;
    }







    /**
     * 
     * @return array
     */
    public function __sleep()
    {
        if ($this->__isInitialized__) {
            return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'ninea', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'localisation', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'domaineDActivite', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'utilisateurs', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'comptes'];
        }

        return ['__isInitialized__', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'id', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'ninea', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'localisation', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'domaineDActivite', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'utilisateurs', '' . "\0" . 'App\\Entity\\Partenaire' . "\0" . 'comptes'];
    }

    /**
     * 
     */
    public function __wakeup()
    {
        if ( ! $this->__isInitialized__) {
            $this->__initializer__ = function (Partenaire $proxy) {
                $proxy->__setInitializer(null);
                $proxy->__setCloner(null);

                $existingProperties = get_object_vars($proxy);

                foreach ($proxy->__getLazyProperties() as $property => $defaultValue) {
                    if ( ! array_key_exists($property, $existingProperties)) {
                        $proxy->$property = $defaultValue;
                    }
                }
            };

        }
    }

    /**
     * 
     */
    public function __clone()
    {
        $this->__cloner__ && $this->__cloner__->__invoke($this, '__clone', []);
    }

    /**
     * Forces initialization of the proxy
     */
    public function __load()
    {
        $this->__initializer__ && $this->__initializer__->__invoke($this, '__load', []);
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __isInitialized()
    {
        return $this->__isInitialized__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitialized($initialized)
    {
        $this->__isInitialized__ = $initialized;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setInitializer(\Closure $initializer = null)
    {
        $this->__initializer__ = $initializer;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __getInitializer()
    {
        return $this->__initializer__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     */
    public function __setCloner(\Closure $cloner = null)
    {
        $this->__cloner__ = $cloner;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific cloning logic
     */
    public function __getCloner()
    {
        return $this->__cloner__;
    }

    /**
     * {@inheritDoc}
     * @internal generated method: use only when explicitly handling proxy specific loading logic
     * @static
     */
    public function __getLazyProperties()
    {
        return self::$lazyPropertiesDefaults;
    }

    
    /**
     * {@inheritDoc}
     */
    public function getId(): ?int
    {
        if ($this->__isInitialized__ === false) {
            return (int)  parent::getId();
        }


        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getId', []);

        return parent::getId();
    }

    /**
     * {@inheritDoc}
     */
    public function getNinea(): ?float
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getNinea', []);

        return parent::getNinea();
    }

    /**
     * {@inheritDoc}
     */
    public function setNinea(float $ninea): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setNinea', [$ninea]);

        return parent::setNinea($ninea);
    }

    /**
     * {@inheritDoc}
     */
    public function getLocalisation(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getLocalisation', []);

        return parent::getLocalisation();
    }

    /**
     * {@inheritDoc}
     */
    public function setLocalisation(string $localisation): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setLocalisation', [$localisation]);

        return parent::setLocalisation($localisation);
    }

    /**
     * {@inheritDoc}
     */
    public function getDomaineDActivite(): ?string
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getDomaineDActivite', []);

        return parent::getDomaineDActivite();
    }

    /**
     * {@inheritDoc}
     */
    public function setDomaineDActivite(string $domaineDActivite): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'setDomaineDActivite', [$domaineDActivite]);

        return parent::setDomaineDActivite($domaineDActivite);
    }

    /**
     * {@inheritDoc}
     */
    public function getUtilisateurs(): \Doctrine\Common\Collections\Collection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getUtilisateurs', []);

        return parent::getUtilisateurs();
    }

    /**
     * {@inheritDoc}
     */
    public function addUtilisateur(\App\Entity\Utilisateur $utilisateur): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addUtilisateur', [$utilisateur]);

        return parent::addUtilisateur($utilisateur);
    }

    /**
     * {@inheritDoc}
     */
    public function removeUtilisateur(\App\Entity\Utilisateur $utilisateur): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeUtilisateur', [$utilisateur]);

        return parent::removeUtilisateur($utilisateur);
    }

    /**
     * {@inheritDoc}
     */
    public function getComptes(): \Doctrine\Common\Collections\Collection
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'getComptes', []);

        return parent::getComptes();
    }

    /**
     * {@inheritDoc}
     */
    public function addCompte(\App\Entity\Compte $compte): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'addCompte', [$compte]);

        return parent::addCompte($compte);
    }

    /**
     * {@inheritDoc}
     */
    public function removeCompte(\App\Entity\Compte $compte): \App\Entity\Partenaire
    {

        $this->__initializer__ && $this->__initializer__->__invoke($this, 'removeCompte', [$compte]);

        return parent::removeCompte($compte);
    }

}
