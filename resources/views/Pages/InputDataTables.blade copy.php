<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Data Tables</h1>
    </div>

    <div class="my-3 p-2" style="background-color: #cccfd8">
        <button type="button" onclick="showhide()" id="btn1" class="btn btn-sm btn-outline-light"
            style="background-color: #4e73df">Memorandum of Understanding (MoU)</button>
        <button type="button" onclick="showhide3()" id="btn3" class="btn btn-sm btn-outline-light">Memorandum of Aggreement (MoA)</button>
        <button type="button" onclick="showhide4()" id="btn4" class="btn btn-sm btn-outline-light">Implementation Arrangement (IA)</button>
        <button type="button" onclick="showhide2()" id="btn2" class="btn btn-sm btn-outline-light">Input Data</button>
    </div>

    <div id="newpost">
        <h1 class="h4">Memorandum of Understanding (MoU)</h1>
        <hr class="m-3">
        @livewire('datatables.mou-datatables')

    </div>
    <div id="newpost3" style="display: none">
        <h3 class="h4">Memorandum of Aggreement (MoA)</h3>
        <hr class="m-3">
        @livewire('datatables.moa-datatables')
    </div>
    <div id="newpost4" style="display: none">
        <h3 class="h4">Implementation Arrangement (IA)</h3>
        <hr class="m-3">
        @livewire('datatables.ia-datatables')
    </div>
    <div id="newpost2" style="display: none">
        @livewire('input-data-tables')
    </div>

    <script>
        function showhide() 
    {  
        var div = document.getElementById("newpost");  
        var div2 = document.getElementById("newpost2");  
        var div3 = document.getElementById("newpost3");  
        var div4 = document.getElementById("newpost4");  
        if (div.style.display !== "block") {  
            div.style.display = "block";  
            div2.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "none";
        }  

        var btn1 = document.getElementById('btn1');
        var btn2 = document.getElementById('btn2');
        var btn3 = document.getElementById('btn3');
        var btn4 = document.getElementById('btn4');
        if (btn1.style.backgroundColor != "#4e73df") {  
            btn1.style.backgroundColor = "#4e73df";  
            btn2.style.backgroundColor = "";
            btn3.style.backgroundColor = "";
            btn4.style.backgroundColor = "";
        }
    }  
    function showhide2() 
    {  
        var div = document.getElementById("newpost");  
        var div2 = document.getElementById("newpost2");  
        var div3 = document.getElementById("newpost3");  
        var div4 = document.getElementById("newpost4");  
        if (div2.style.display !== "block") {  
            div2.style.display = "block";  
            div.style.display = "none";
            div3.style.display = "none";
            div4.style.display = "none";
        }  

        var btn1 = document.getElementById('btn1');
        var btn2 = document.getElementById('btn2');
        var btn3 = document.getElementById('btn3');
        var btn4 = document.getElementById('btn4');
        if (btn2.style.backgroundColor != "#4e73df") {  
            btn2.style.backgroundColor = "#4e73df";  
            btn1.style.backgroundColor = "";
            btn3.style.backgroundColor = "";
            btn4.style.backgroundColor = "";
        }
    }  
    function showhide3() 
    {  
        var div = document.getElementById("newpost");  
        var div2 = document.getElementById("newpost2");  
        var div3 = document.getElementById("newpost3");  
        var div4 = document.getElementById("newpost4");  
        if (div3.style.display !== "block") {  
            div3.style.display = "block";  
            div.style.display = "none";
            div2.style.display = "none";
            div4.style.display = "none";
        }  

        var btn1 = document.getElementById('btn1');
        var btn2 = document.getElementById('btn2');
        var btn3 = document.getElementById('btn3');
        var btn4 = document.getElementById('btn4');
        if (btn3.style.backgroundColor != "#4e73df") {  
            btn3.style.backgroundColor = "#4e73df";  
            btn1.style.backgroundColor = "";
            btn2.style.backgroundColor = "";
            btn4.style.backgroundColor = "";
        }
    }  function showhide4() 
    {  
        var div = document.getElementById("newpost");  
        var div2 = document.getElementById("newpost2");  
        var div3 = document.getElementById("newpost3");  
        var div4 = document.getElementById("newpost4");  
        if (div4.style.display !== "block") {  
            div4.style.display = "block";  
            div.style.display = "none";
            div2.style.display = "none";
            div3.style.display = "none";
        }  

        var btn1 = document.getElementById('btn1');
        var btn2 = document.getElementById('btn2');
        var btn3 = document.getElementById('btn3');
        var btn4 = document.getElementById('btn4');
        if (btn4.style.backgroundColor != "#4e73df") {  
            btn4.style.backgroundColor = "#4e73df";  
            btn1.style.backgroundColor = "";
            btn2.style.backgroundColor = "";
            btn3.style.backgroundColor = "";
        }
    }  
    </script>
</div>