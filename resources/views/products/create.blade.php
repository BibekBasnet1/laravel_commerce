@extends('layouts.app')

@section('title')
    Add Product
@endsection

@section('style')
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/css/multi-select-tag.css"> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/bootstrap.tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>

    <style>
        .backgroundButton {
            padding: 5px;
            border-radius: 5px;
            margin: 0px 5px 10px 0;
            width: 50px;
            height: 50px;
            display: block;
            text-align: center;
        }

        .backgroundColorChoice {
            display: flex;
        }

        .label-info {
            background-color: purple;
            color: white;
            width: 30px;
        }

        .clicked {
            border: 2px solid red;
            /* Change the border style to your preference */
        }
    </style>
@endsection

@section('content')
    <div class="container border border-2" style="width: 50%">
        <p class="text-center fs-3">Create Product</p>
        <form action="{{ route('products.store') }}" class="form" method="post" enctype="multipart/form-data">
            @csrf
            <div class="form-group container">
                <label for="" class="form-label mt-2 mb-2 fs-6">Product Name</label>
                <input placeholder="" class="form-control mb-2 product_name" name="name" type="text" value="">

                <label for="" class="form-label mt-2 mb-2 fs-6">Product Price</label>
                <input placeholder="" class="form-control mb-2" name="price" type="number" value="">

                <input type="hidden" name="attributesInput" id="attributesInput" value="">



                <label for="" class="form-label mt-2 mb-2 fs-6">Category</label>
                <select name="category_id" class="form-select">

                    @foreach ($categoryProducts as $key => $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>

                {{-- images of the product --}}

                <label for="" class="mt-4 mb-3">Product Colors</label><br>
                <div class="backgroundColorChoice">
                    @foreach ($product_color as $productColor)
                        <input type="checkbox" name="colorValue[]" value="{{ $productColor }}" class="colorValue"
                            id="color-{{ $productColor }}" data-currentColor="color-{{ $productColor }}" hidden>
                        <i class="fa-solid fa-check check-icon" style="color: #ffffff;visibility: none;"></i>
                        <label class="backgroundButton" style="background-color: {{ $productColor }}"
                            for="color-{{ $productColor }}" data-productColor="{{ $productColor }}">
                        </label>
                    @endforeach
                </div>

                <br>

                {{--  initially it will be display none  --}}

                <select name="attribute[]" class="form-select attribute " id="attributeSelect" multiple>

                    @foreach ($attributes as $productAttribute)
                        <option value="{{ $productAttribute->id }}">{{ $productAttribute->name }}</option>
                    @endforeach

                </select>

                <div class="attributes-container">

                </div>

                {{-- for the table  --}}

                <div class="table-container variant-container">

                </div>
                {{-- end of the table logic  --}}

                <label for="" class="form-label mt-2 mb-2 fs-6">Product Image</label>
                <input placeholder="" class="form-control mb-2" name="image" type="file">

                <label for="" class="form-label mt-2 mb-2 fs-6">No of Stock</label>
                <input placeholder="" class="form-control mb-2" name="stock" type="number">

                <button type="submit" class="btn btn-success mt-2">
                    Submit
                </button>

            </div>
        </form>
    </div>
@endsection

@section('script')
    {{-- <script src="https://cdn.jsdelivr.net/gh/habibmhamadi/multi-select-tag/dist/js/multi-select-tag.js"></script> --}}

    <script>
        let multipleAttributeSelect = document.querySelector(".attribute");
        let attributeInputBoxContainer = document.querySelector('.attributes-container');
        let productValue = document.querySelector('.product_name');
        var colorValues = [];
        var finalValues = [];

        let currentSelectedColor = document.querySelectorAll('.colorValue');

        currentSelectedColor.forEach((color) => {
            color.addEventListener('click', (e) => {
                let currentColor = color.getAttribute('data-currentColor');
                color.classList.toggle('clicked');
            })
        })



        function updateVariantTable() {
            // if(data.length == 0){
            //    return;
            // }
            var combinations = []
            var productName = $('.product_name').val();
            finalValues = [];

            let customInputs = extractCustomInputs();


            // console.log(customInputs);
            // console.log(customInputs);
            let newCustomInputs = customInputs.map((item) => item.split(','));

            // Generate combinations
            //only attribute combination
            let example = newCustomInputs.reduce((combinations, currentArray) => {
                if (combinations.length === 0) {
                    return currentArray;
                }

                return combinations.flatMap(combination => {
                    return currentArray.map(item => combination + '-' +
                        item);
                });
            }, []);

            let colorLength = colorValues.length;

            if (colorLength > 0 && example.length > 0) {
                for (const item1 of colorValues) {
                    for (const item2 of example) {
                        combinations.push(`${item1}-${item2}`);
                    }
                }
            } else if ((colorLength > 0 && example.length <= 0)) {
                for (const item1 of colorValues) {
                    combinations.push(`${item1}`);
                }
            } else {
                //check attribute
                for (const item2 of example) {
                    combinations.push(`${item2}`);
                }
            }



            var populateTable = ` <table class="table mt-3 productVariantTable">
            <thead>
                        <tr>
                            <th scope="col">ProductVariant Name</th>
                            <th scope="col">ProductVariant Image</th>
                            <th scope="col">Price</th>
                            <th scope="col">Stock</th>
                        </tr>
                    </thead>
                    <tbody>`;

            $.each(combinations, function(key, value) {
                // console.log(value)
                populateTable += `<tr>
                            <td>
                                ` + productName + "-" + value + `;
                            </td>

                            <td>
                                <input placeholder="" class="form-control mb-2" name="variantImage[]" type="file">
                            </td>

                            <td>
                                <input placeholder="" class="form-control mb-2" name="variantPrice[]" type="number">
                            </td>
                            <td>
                                <input placeholder="" class="form-control mb-2" name="variantStock[]" type="number">
                            </td>

                            <!-- Hidden fields for productName and value -->

                            <input type="hidden" name="variantValue[]" value="` + value + `">


                        </tr>`;
            });

            populateTable += `<tr>                            
                    </tbody>
                </table>`;
            $('.variant-container').html(populateTable);

        }

        const changeValueOnKeyEnterTable = () => {
            let inputParentDiv = document.querySelectorAll('.bootstrap-tagsinput');
            inputParentDiv.forEach((element) => {
                // let combinations = [];
                element.addEventListener('keypress', function(event) {
                    combinations = [];
                    // Check if the event target is the input field and the key code is 13 (Enter key)
                    if (event.target.tagName === 'INPUT' && event.keyCode === 13) {
                        updateVariantTable();
                    }
                });

                const inputField = element.querySelector('input[type="text"]');

                inputField.addEventListener('keydown', (event) => {
                    let customInputs = extractCustomInputs();
                    combinations = [];
                    if (event.code === 'Backspace' && inputField.value === '') {
                        // colorValues = [];
                        const tags = element.querySelectorAll('.tag');
                        // console.log(tags);
                        if (tags.length > 0) {
                            const lastTag = tags[tags.length - 1];
                            const tagName = lastTag.textContent.trim();

                            let newCustomInputs = customInputs.map((item) => item.split(','));

                            updateVariantTable();

                        }
                    }
                });
            })
        }

        let customInputs = extractCustomInputs();

        multipleAttributeSelect.onchange = () => {

            currentSelectedAttributeBoxes();
            changeValueOnKeyEnterTable();
        }



        // function extractCustomInputs() {
        //     const customInputs = [];
        //     const inputElements = document.querySelectorAll('.form-control.tagclass');

        //     let labelElement = takesOutAttributesName();

        //     inputElements.forEach(inputElement => {
        //         const inputValue = inputElement.value.trim();
        //         // const labelValue = attributeLabel.value();

        //         customInputs.push(`${labelElement} => ${inputValue}`);
        //     });


        //     return customInputs;
        // }



        function extractCustomInputs() {
            const attributesInput = {};
            const customInputs = [];
            const inputElements = document.querySelectorAll('.form-control.tagclass');
            const labelElements = document.querySelectorAll('.attributes-container label');

            const elements = [];
            let resultObject = {};

            // Convert labelElements NodeList to an array for easier access
            const labelArray = Array.from(labelElements);
            // console.log(labelArray)

            inputElements.forEach((inputElement, index) => {

                const inputValue = inputElement.value.trim();
                // Use the corresponding label from labelArray based on the current index
                const labelElement = labelArray[index];
                const labelText = labelElement ? labelElement.textContent.trim() : '';

                // Check if the key (labelText) already exists in the attributesInput
                if (!attributesInput[labelText]) {
                    attributesInput[labelText] = {};
                }

                attributesInput[labelText][index] = inputValue;

                for (const key in attributesInput) {
                    resultObject[key] = {};

                    for (const index in attributesInput[key]) {
                        const values = attributesInput[key][index].split(',').map(value => value.trim());

                        for (let i = 0; i < values.length; i++) {
                            resultObject[key][i.toString()] = values[i];
                        }
                    }
                }

                // Push the trimmed input value to customInputs array
                customInputs.push(inputValue);

            });

            document.getElementById('attributesInput').value = JSON.stringify(resultObject);

            return customInputs;
        }


        // change in the color 

        $(".colorValue").change(function() {

            // let custom_inputs = [];
            // let combinations = [];
            var selectedValue = $(this).val();
            // let customInputs = extractCustomInputs();
            if (this.checked) {
                colorValues.push(selectedValue);
            } else {
                var toRemove = jQuery.inArray(selectedValue, colorValues);
                colorValues.splice(toRemove, 1);
            }


            updateVariantTable();
            // if (customInputs.length == 0) {
            //     updateVariantTable(colorValues);
            // } else {
            // Get the custom i
            // let newCustomInputs = customInputs.map((item) => item.split(','));

            // // Generate combinations
            // let example = newCustomInputs.reduce((combinations, currentArray) => {
            //     if (combinations.length === 0) {
            //         return currentArray;
            //     }

            //     return combinations.flatMap(combination => {
            //         return currentArray.map(item => combination + '-' + item);
            //     });
            // }, []);


            // for (const item1 of colorValues) {
            //     // console.log(item1);
            //     for (const item2 of example) {
            //         // console.log(item2);
            //         combinations.push(`${item1}-${item2}`);
            //     }
            // }
            // updateVariantTable();
            // }






        });

        // Function to generate input elements based on selected options
        const currentSelectedAttributeBoxes = () => {
            // let attributesSelected = [];
            attributeInputBoxContainer.innerHTML = ""; // Clear the container

            // Loop through the options to find selected ones
            for (let i = 0; i < multipleAttributeSelect.options.length; i++) {

                if (multipleAttributeSelect.options[i].selected) {

                    // Create a new input element for each selected option
                    const labelElement = document.createElement('label');
                    labelElement.textContent = multipleAttributeSelect.options[i].text;
                    const inputElement = document.createElement('input');
                    inputElement.type = 'text';
                    inputElement.value = '';
                    inputElement.setAttribute('data-role', 'tagsinput');
                    inputElement.className = 'form-label mb-2 mt-2 fs-6 form-control tagclass';
                    inputElement.placeholder = `Product Variant ${multipleAttributeSelect.options[i].text}`;

                    // Append the input element to the container
                    attributeInputBoxContainer.appendChild(labelElement);
                    attributeInputBoxContainer.appendChild(inputElement);

                    $('input.tagclass').tagsinput('refresh');

                }
            }

        };
    </script>
@endsection
