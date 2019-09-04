var svg = d3.select("svg"),
    width = +svg.attr("width"),
    height = +svg.attr("height");

var link = svg.selectAll(".link")
	.data(graph.links)
	.enter()
	.append("line")
  	  .attr("x1", function(d) { return getNode(d.source)["x_axis"]; })
      .attr("y1", function(d) { return getNode(d.source)["y_axis"]; })
      .attr("x2", function(d) { return getNode(d.target)["x_axis"]; })
      .attr("y2", function(d) { return getNode(d.target)["y_axis"]; })
	  .attr("stroke", function (d) { return setColor(d.source, d.target); });

var node = svg.selectAll(".node")
	.data(graph.nodes)
	.enter()
	.append("circle")
		.attr("cx", function (d) { return d.x_axis; })
		.attr("cy", function (d) { return d.y_axis; })
		.attr("r", function (d) { return d.radius; })
		.attr("fill", function (d) { return d.color; })
		.on("click", updateForm);


var text = svg.selectAll(".text")
	.data(graph.nodes)
	.enter()
	.append("text")
      .attr("x", function (d) { return d.x_axis + 8; })
	  .attr("y", function (d) { return d.y_axis + 5; })
	  .text(function(d) { return d.id })
	  .on("click", updateForm);

function getNode( name ){
	for( i in graph.nodes ){
		if( graph.nodes[i].id == name ){
			return graph.nodes[i];
		}
	}
	return false;
}

function setColor( source, target ){
	for( i=0 ; i<path.length ; i++ ){
		if( i==path.length) return ;//"#888";

		if( path[i]==source && path[i+1]==target ) return "red";
		if( path[i]==target && path[i+1]==source ) return "red";
	}
	//return "#888";
}

function updateForm(d, i){
	from = document.getElementsByName('from')[0];
	to = document.getElementsByName('to')[0];

	if( from.value == '' ){
		from.value = d.id;
	} else {
		to.value = d.id;
		console.log( document.forms[0] );
		document.forms[0].submit();
	}
}
