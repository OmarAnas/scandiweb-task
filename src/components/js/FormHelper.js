/*
* Intializing values for Formik form
*/
export const initialValues = {
    sku: '', productName: '', price: '', productType: '',
    size: '', weight: '', height: '', width: '', length: ''
};

/* 
* Validation Function 
*/
export const validate = (retrieveProductBySKU, productTypeFields) => async (values) => {

    const errors = {};

    if (!values.sku.trim()) {
        errors.sku = "SKU is required."
    }
    else {
        await retrieveProductBySKU(values.sku.trim())
            .then(response => {
                if (response.data.exists) {
                    errors.sku = "SKU is already in use! Try another one.";
                }
            })
            .catch(error => {
                console.error('Error fetching data:', error);
                errors.sku = "Sorry, error checking SKU availablity! Try again later."
            });
    }

    if (!values.productName.trim()) {
        errors.productName = "Name is required."
    }

    if (values.price === null || values.price === '') {
        errors.price = "Price (in numbers) is required."
    } else if (values.price < 0 || isNaN(values.price)) {
        errors.price = "Price must be a postive number."
    }

    if (!values.productType.value) {
        errors.productType = "Type is required! Please select one."
    } else {
        productTypeFields[values.productType.value].forEach(field => {
            var str = field.name;
            str = str[0].toUpperCase() + str.slice(1);
            if (!values[field.name]) {
                errors[field.name] = `${str} (in numbers) is required.`
            } else if (values[field.name] < 0 || isNaN(values[field.name])) {
                errors[field.name] = `${str} must be a positive number.`
            }
        })
    }

    return errors
}

/*
* Called when submitting the form
*/
export const onSubmit = (productTypeFields, createProduct, navigate) => (values) => {

    const selectedOption = values.productType;
    const productTypeId = selectedOption.options[selectedOption.selectedIndex].id;

    //getting all the details of the selected type
    const typeDetails = productTypeFields[selectedOption.value];

    // looping through the details and choosing the attribute name to append its value in a string 
    const attributeValue = typeDetails.map((type, index) => {

        var attribute = "";

        if (typeDetails.length > 1 && index !== typeDetails.length - 1) {
            attribute += values[type.name] + "x";
        } else {
            attribute += values[type.name];
        }
        return attribute;
    }).join('')

    const product = {
        id: "",
        sku: values.sku.trim(),
        name: values.productName.trim(),
        price: values.price,
        product_type_id: productTypeId,
        attribute_value: attributeValue
    }
    createProduct(product)
        .then(response => navigate("/"))
        .catch(error => console.error(error))
}
