function loadCurrentPrivileges(element, memberId) {
	element = $(element);
	Element.extend(element);
	var output = new Ajax.Request("/resource/application/service/privelage.php", {
		parameters: {
			Action: "LoadCurrentPrivileges",
			MemberId: memberId
		},
		asynchronous: false,
		onSuccess: function(transport) {
  			var response = transport.responseText.evalJSON();
	  		response.data.each(function(privelage) {
	  			populatePrivileges(element, privelage, memberId);
				var privelageItem = $("privelage-" + privelage.Id.Data);
				if (privelageItem) {
					privelageItem.addClassName("invited");
					privelageItem.stopObserving("dblclick");
					//destroy draggable
					if (privelageItem.dragHandle) {
						privelageItem.dragHandle.destroy();
					}
				}
			});
		}
	});
}

function loadAvailablePrivileges(element, memberId) {
	element = $(element);
	Element.extend(element);
	var output = new Ajax.Request("/resource/application/service/privelage.php", {
		parameters: {
			Action: "LoadAvailablePrivileges",
			MemberId: memberId
		},
		asynchronous: false,
	  	onSuccess: function(transport) {
	  		var response = transport.responseText.evalJSON();
	  		var ul = document.createElement("ul");
			element.appendChild(ul);
	  		response.data.each(function(privelage) {
	  			var li = createPrivelageListItem(privelage);
	  			li.id = "privelage-" + privelage.Id.Data;
	  			setupDraggable(li);
	  			ul.appendChild(li);
	  		});
		}
	});
}

function add(element, memberId) {
	var privileges = $("privileges");
	Element.extend(privileges);
	var newElement = document.createElement("li");
	Element.extend(newElement);
	newElement.innerHTML = element.innerHTML;
	newElement.style.backgroundImage = element.style.backgroundImage;
	newElement.className = "privelage-card dropped";
	newElement.id = "invited-" + element.value;
	addDeleteButton(newElement, element.value, memberId);
	privileges.appendChild(newElement);
	var privelage = $("privelage-" + element.value);
	if (privelage) {
		privelage.addClassName("invited");
		privelage.stopObserving("dblclick");
		//destroy draggable
		if (privelage.dragHandle) {
			privelage.dragHandle.destroy();
		}
	}
	var output = new Ajax.Request("/resource/application/service/privelage.php", {
		parameters: {
			Action: "AddPrivelage",
			SecurityGroupId: element.value,
			MemberId: memberId
		},
		asynchronous: false,
	  	onSuccess: function(transport) {
	  		var response = transport.responseText.evalJSON();
	  		var ul = document.createElement("ul");
			element.appendChild(ul);
	  		response.data.each(function(privelage) {
	  			var li = createPrivelageListItem(privelage);
	  			li.id = "privelage-" + privelage.Id.Data;
	  			setupDraggable(li);
	  			ul.appendChild(li);
	  		});
		}
	});
}

function createPrivelageListItem(privelage) {
	var li = document.createElement("li");
	Element.extend(li);
	li.name = "privelage";
	li.innerHTML = "<p class=\"privelage-name\">" + privelage.Name.Data + "</p>";
	li.value = privelage.Id.Data;
	li.className = "privelage-card";
	return li;
}

function populatePrivileges(element, privelage, memberId) {
	var li = createPrivelageListItem(privelage);

	addDeleteButton(li, privelage.Id.Data, memberId);
	li.addClassName("dropped");
	element.appendChild(li);

	var privelageElement = $("privelage-" + privelage.Id.Data);
	if (privelageElement) {
		privelageElement.addClassName("invited");
	}
}

function addDeleteButton(element, privelageId, memberId) {
	var span = document.createElement("span");
	Element.extend(span);
	span.className = "micro-button delete";
	span.title = "Unselect Privelage";
	span.innerHTML = "<span>Delete</span>";
	span.observe("click", (function(event) {
		setupDraggable("privelage-" + privelageId);
	var output = new Ajax.Request("/resource/application/service/privelage.php", {
			parameters: {
				Action: "RemovePrivelage",
				SecurityGroupId: privelageId,
				MemberId: memberId
			},
			asynchronous: false,
		  	onSuccess: function(transport) {
		  		var response = transport.responseText.evalJSON();
		  		element.remove();
			}
		});
	}).bind(this));
	element.insertBefore(span, element.firstChild);
}

function setupDraggable(element, memberId) {
	element = $(element);
	element.dragHandle = new Draggable(element, {revert: true, reverteffect: function(e) { e.style.top = 0; e.style.left = 0; }});
	element.removeClassName("invited");
	element.observe("dblclick", (function(event) {
		add(element, memberId);
	}).bind(this));
}