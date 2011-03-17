var TagControl = Class.create();

TagControl.prototype = {
	tags: [],
	observers: [],

  initialize: function(tags, inputElement, displayElement, hiddenElement, autoCompleteElement) {
  	this.inputElement = $(inputElement);
  	this.displayElement = $(displayElement);
  	this.hiddenElement = $(hiddenElement);
  	this.autoCompleteElement = $(autoCompleteElement);
  	this.tags = tags;
  	var me = this;
  	this.inputElement.observe("keypress", function(event) {
  		switch(event.keyCode) {
  			case Event.KEY_RETURN:
  				Event.stop(event);
  				if (!me.autoCompleteElement.visible()) {
  					me.add();
  				}
  				break;
  		}
  	});

  	this.populateList();
  },

  load: function(url) {
  	var me = this;
  	var tagToData = new Ajax.Request(url, {
  		onSuccess: function(transport) {
  			var response = transport.responseText.evalJSON();
  			response.data.each(function(tag) {
  				me.tags.push(tag);
  				me.populateList();
  			});
  		}
  	});
  },

  add: function() {
		this.addValue(this.inputElement.value);
		this.inputElement.value = "";
  },

  addObserver: function(observer) {
  	this.observers.push(observer);
  },

  update: function(action, data) {
  	this.observers.each(function(observer) {
  		observer.notify(action, data);
  	});
  },

  addValue: function(tag) {
  	if ((!tag) || (this.tags.indexOf(tag) != -1)) {
			return false;
		}
		this.tags.push(tag);
		this.addToDom(tag);
		this.hiddenElement.value += tag + "\n";

		this.update("add", tag);
  },

  remove: function(tag, listElement) {
  	this.tags = this.tags.without(tag);
  	listElement.remove();
  	this.setHiddenElement();

  	this.update("remove", tag);
  },

  addToDom: function(value) {
		var li = document.createElement("li");
		Element.extend(li);
		li.innerHTML = "<span>" + value + "</span>";

		var link = document.createElement("span");
		Element.extend(link);
		link.innerHTML = "<strong title='Remove Tag'>x</strong>";
		link.className = "micro-button";

		link.observe("click", (function() {
				this.remove(value, li);
			}).bind(this)
		);

		li.appendChild(link);
		this.displayElement.appendChild(li);
  },

  populateList: function() {
  	this.displayElement.innerHTML = "";
  	this.hiddenElement.value = "";
  	var me = this;
  	this.tags.each(function(tag) {
  		me.addToDom(tag);
  		me.hiddenElement.value += tag + "\n";
  	});
  },

  setHiddenElement: function() {
  	this.hiddenElement.value = "";
  	var me = this;
  	this.tags.each(function(tag) {
  		me.hiddenElement.value += tag + "\n";
  	});
  }
};