<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <script src="lib/d3.js"></script>
    <style>
      h1, h2, h3, p {
          top: 550px;
          position: absolute;
          left: 30px;
          font-size: 1.3em;
          font-weight: 100;
      }
      h1{
        font-weight: 500;
      }
      h2 {
          top: 580px;
          font-size: 1em;
      }
      h3 {
        top: 602px;
        font-size: 0.8em;
      }
      p{
        top:700px;
        font-size: 0.7em;
      }
      img{
        position: absolute;
        top: 450px;
        left: 100px;
        width: 100px;
      }
    </style>
    <script type="text/javascript">
      function draw(geo_data) {
        "use strict";
        var margin = 30,
            width = 1400,
            height = 680;
        var svg = d3.select("body")
            .append("svg")
            .attr("width", width + margin)
            .attr("height", height + margin)
            .append('g')
            .attr('class', 'map');
        var projection =  d3.geoMercator()
                               .scale(200)
                               .translate( [760, 470]);
        var path = d3.geoPath().projection(projection);
        var map = svg.selectAll('path')
                     .data(geo_data.features)
                     .enter()
                     .append('path')
                     .attr('d', path)
                     .style('fill', '#b3cccc')
                     .style('stroke', 'black')
                     .style('stroke-width', 0.4);
      function drawpoint(data) {
        // draw circles
        svg.selectAll("circle")
            .data(data)
            .enter()
            .append("circle")
            .attr("cx", function(d) {
                      return projection([ +d["Longitude"], +d["Latitude"] ])[0];
                      })
            .attr("cy", function(d) {
                      return projection([ +d["Longitude"], +d["Latitude"] ])[1];
                      })
            .attr("r", 2.2)
            .attr("fill", "#007245")
            .attr('opacity', 0.6)
            .on("mouseover", function(d){
                  d3.select("h2")
                    .text(d["Store Name"]);
                  d3.select("h3").text(d["Street Address"]);
                  d3.select(this).attr("class","incident hover");
              })
            .on("mouseout", function(d){
              d3.select("h2").text("View the store name and address");
              d3.select("h3").text("Move the mouse over points");
              d3.select(this).attr("class","incident");
          });
          }
      d3.csv("lib/starbucks.csv",drawpoint);
      };
      </script>
  </head>
<body>
  <h1>Starbucks Locations Worldwide</h1>
  <h2>View the store name and address</h2>
  <h3>Move the mouse over points</h3>
  <script type="text/javascript">
  d3.json("lib/world_countries.json", draw);
  </script>
</body>
</html>