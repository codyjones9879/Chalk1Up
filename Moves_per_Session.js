


var w_moves = setWidthToWindow();
var h_moves = setHeightToWindow();
var padding_moves = 20;
var yscale_moves = 0;
var div_string_moves = "#moves_over_time";
var tickWidth = (-w_moves + 75);


var y = d3.scale.linear()
				.domain([0, d3.max(moves_viewer)])
				.range([0 + padding_moves, h_moves - padding_moves]);
var x = d3.scale.linear()
				.domain([0, moves_viewer.length])
				.range([0 + padding_moves, w_moves - padding_moves]);


var svg_moves = d3.select(div_string_moves)
    .append("svg")
    .attr("width", w_moves)
    .attr("height", h_moves);
 
var g = svg_moves.append("svg:g")
    .attr("transform", "translate(0, 0)");


var line = d3.svg.line()
				 .interpolate("basis")
			     .x(function(d,i) { return x(i); })
			     .y(function(d) { return -1 * y(d); });


var drawnLine = g.append("svg:path")
				 .attr("d", line(moves_viewer));


var rules_moves = drawYRules(y, svg_moves, tickWidth);


