/* Copyright (c) 2006 Yahoo! Inc. All rights reserved. */

/**
 * Contains the tree view state data and the root node.  This is an
 * ordered tree; child nodes will be displayed in the order created, and
 * there currently is no way to change this.
 *
 * @constructor
 * @todo prune, graft, reload, repaint
 * @param {string} id The id of the element that the tree will be inserted
 * into.
 */
YAHOO.widget.TreeView = function(id) {
	if (id) { this.init(id); }
};

/**
 * The total number of nodes in this tree
 * @type int
 */
YAHOO.widget.TreeView.nodeCount = 0;


YAHOO.widget.TreeView.prototype = {

    /**
     * The id of tree container element
     *
     * @type String
     */
    id: null,

     /**
     * Flat collection of all nodes in this tree
     *
     * @type Node[]
     * @private
     */
    _nodes: null,

    /**
     * We lock the tree control while waiting for the dynamic loader to return
     *
     * @type boolean
     */
    locked: false,

    /**
     * The animation to use for expanding children, if any
     *
     * @type string
     * @private
     */
    _expandAnim: null,

    /**
     * The animation to use for collapsing children, if any
     *
     * @type string
     * @private
     */
    _collapseAnim: null,

    /**
     * The current number of animations that are executing
     *
     * @type int
     * @private
     */
    _animCount: 0,

    /**
     * The maximum number of animations to run at one time.
     *
     * @type int
     */
    maxAnim: 2,

    /**
     * Sets up the animation for expanding children
     *
     * @param {string} the type of animation (acceptable constants in YAHOO.widget.TVAnim)
     */
    setExpandAnim: function(type) {
        if (YAHOO.widget.TVAnim.isValid(type)) {
            this._expandAnim = type;
        }
    },

    /**
     * Sets up the animation for collapsing children
     *
     * @param {string} the type of animation (acceptable constants in YAHOO.widget.TVAnim)
     */
    setCollapseAnim: function(type) {
        if (YAHOO.widget.TVAnim.isValid(type)) {
            this._collapseAnim = type;
        }
    },

    /**
     * Perform the expand animation if configured, or just show the
     * element if not configured or too many animations are in progress
     *
     * @param el {HTMLElement} the element to animate
     * @return {boolean} true if animation could be invoked, false otherwise
     */
    animateExpand: function(el) {
        this.logger.debug("animating expand");

        if (this._expandAnim && this._animCount < this.maxAnim) {
            // this.locked = true;
            var tree = this;
            var a = YAHOO.widget.TVAnim.getAnim(this._expandAnim, el, 
                            function() { tree.expandComplete(); });
            if (a) { 
                ++this._animCount;
                a.animate();
            }

            return true;
        }

        return false;
    },

    /**
     * Perform the collapse animation if configured, or just show the
     * element if not configured or too many animations are in progress
     *
     * @param el {HTMLElement} the element to animate
     * @return {boolean} true if animation could be invoked, false otherwise
     */
    animateCollapse: function(el) {
        this.logger.debug("animating collapse");

        if (this._collapseAnim && this._animCount < this.maxAnim) {
            // this.locked = true;
            var tree = this;
            var a = YAHOO.widget.TVAnim.getAnim(this._collapseAnim, el, 
                            function() { tree.collapseComplete(); });
            if (a) { 
                ++this._animCount;
                a.animate();
            }

            return true;
        }

        return false;
    },

    /**
     * Function executed when the expand animation completes
     */
    expandComplete: function() {
        this.logger.debug("expand complete: " + this.id);
        --this._animCount;
        // this.locked = false;
    },

    /**
     * Function executed when the collapse animation completes
     */
    collapseComplete: function() {
        this.logger.debug("collapse complete: " + this.id);
        --this._animCount;
        // this.locked = false;
    },

    /**
     * Initializes the tree
     *
     * @parm {string} id the id of the element that will hold the tree
     * @private
     */
    init: function(id) {

        this.id = id;
        this._nodes = new Array();

        // store a global reference
        YAHOO.widget.TreeView.trees[id] = this;

        // Set up the root node
        this.root = new YAHOO.widget.RootNode(this);

        this.logger = new ygLogger("TreeView");

        this.logger.debug("tree init: " + id);
    },

    /**
     * Renders the tree boilerplate and visible nodes
     */
    draw: function() {
        var html = this.root.getHtml();
        document.getElementById(this.id).innerHTML = html;
        this.firstDraw = false;
    },

    /**
     * Nodes register themselves with the tree instance when they are created.
     *
     * @param node {Node} the node to register
     * @private
     */
    regNode: function(node) {
        this._nodes[node.index] = node;
    },

    /**
     * Returns the root node of this tree
     *
     * @return {Node} the root node
     */
    getRoot: function() {
        return this.root;
    },

    /**
     * Configures this tree to dynamically load all child data
     *
     * @param {function} fnDataLoader the function that will be called to get the data
     */
    setDynamicLoad: function(fnDataLoader) { 
        // this.root.dataLoader = fnDataLoader;
        // this.root._dynLoad = true;
        this.root.setDynamicLoad(fnDataLoader);
    },

    /**
     * Expands all child nodes.  Note: this conflicts with the "multiExpand"
     * node property.  If expand all is called in a tree with nodes that
     * do not allow multiple siblings to be displayed, only the last sibling
     * will be expanded.
     */
    expandAll: function() { 
        if (!this.locked) {
            this.root.expandAll(); 
        }
    },

    /**
     * Collapses all expanded child nodes in the entire tree.
     */
    collapseAll: function() { 
        if (!this.locked) {
            this.root.collapseAll(); 
        }
    },

    /**
     * Returns a node in the tree that has the specified index (this index
     * is created internally, so this function probably will only be used
     * in html generated for a given node.)
     *
     * @param {int} nodeIndex the index of the node wanted
     * @return {Node} the node with index=nodeIndex, null if no match
     */
    getNodeByIndex: function(nodeIndex) {
        var n = this._nodes[nodeIndex];
        return (n) ? n : null;
    },

    /**
     * Returns a node that has a matching property and value in the data
     * object that was passed into its constructor.  Provides a flexible
     * way for the implementer to get a particular node.
     *
     * @param {object} property the property to search (usually a string)
     * @param {object} value the value we want to find (usuall an int or string)
     * @return {Node} the matching node, null if no match
     */
    getNodeByProperty: function(property, value) {
        for (var i in this._nodes) {
            var n = this._nodes[i];
            if (n.data && value == n.data[property]) {
                return n;
            }
        }

        return null;
    },

    /**
     * Abstract method that is executed when a node is expanded
     *
     * @param node {Node} the node that was expanded
     */
    onExpand: function(node) { },

    /**
     * Abstract method that is executed when a node is collapsed
     *
     * @param node {Node} the node that was collapsed.
     */
    onCollapse: function(node) { }

};

/**
 * Global cache of tree instances
 *
 * @type Array
 * @private
 */
YAHOO.widget.TreeView.trees = [];

/**
 * Global method for getting a tree by its id.  Used in the generated
 * tree html.
 *
 * @param treeId {String} the id of the tree instance
 * @return {TreeView} the tree instance requested, null if not found.
 */
YAHOO.widget.TreeView.getTree = function(treeId) {
	var t = YAHOO.widget.TreeView.trees[treeId];
	return (t) ? t : null;
};


/**
 * Global method for getting a node by its id.  Used in the generated
 * tree html.
 *
 * @param treeId {String} the id of the tree instance
 * @param nodeIndex {String} the index of the node to return
 * @return {Node} the node instance requested, null if not found
 */
YAHOO.widget.TreeView.getNode = function(treeId, nodeIndex) {
	var t = YAHOO.widget.TreeView.getTree(treeId);
	return (t) ? t.getNodeByIndex(nodeIndex) : null;
};

/**
 * Adds an event.  Replace with event manager when available
 *
 * @param el the elment to bind the handler to
 * @param {string} sType the type of event handler
 * @param {function} fn the callback to invoke
 * @param {boolean} capture if true event is capture phase, bubble otherwise
 */
YAHOO.widget.TreeView.addHandler = function (el, sType, fn, capture) {
	capture = (capture) ? true : false;
	if (el.addEventListener) {
		el.addEventListener(sType, fn, capture);
	} else if (el.attachEvent) {
		el.attachEvent("on" + sType, fn);
	} else {
		el["on" + sType] = fn;
	}
};

/**
 * Attempts to preload the images defined in the styles used to draw the tree by
 * rendering off-screen elements that use the styles.
 */
YAHOO.widget.TreeView.preload = function() {

	var styles = [
		"ygtvtn",	
		"ygtvtm",	
		"ygtvtmh",	
		"ygtvtp",	
		"ygtvtph",	
		"ygtvln",	
		"ygtvlm",	
		"ygtvlmh",	
		"ygtvlp",	
		"ygtvlph",	
		"ygtvloading"
		];

	var sb = [];
	
	for (var i = 0; i < styles.length; ++i) { 
		sb[sb.length] = '<span class="' + styles[i] + '">&nbsp;</span>';
	}

	var f = document.createElement("div");
	var s = f.style;
	s.position = "absolute";
	s.top = "-1000px";
	s.left = "-1000px";
	f.innerHTML = sb.join("");

	document.body.appendChild(f);
};

YAHOO.widget.TreeView.addHandler(window, 
                "load", YAHOO.widget.TreeView.preload);

