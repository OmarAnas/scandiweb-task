export const productTypeFields = {
    "DVD": [{
        label: "Size (MB)",
        placeholder: "Size in MBs",
        name: "size",
        description: "Size in Megabytes (MB)."
    }],
    "Book": [{
        label: "Weight (KG)",
        placeholder: "Weight in KGs",
        name: "weight",
        description: "Weight in Kilograms (KG)."
    }],
    "Furniture": [{
        label: "Height (CM)",
        placeholder: "Height in CMs",
        name: "height"
    },
    {
        label: "Width (CM)",
        placeholder: "Width in CMs",
        name: "width"
    },
    {
        label: "Length (CM)",
        placeholder: "Length in CMs",
        name: "length",
        description: "Dimensions (HxWxL) in Centimeters (CM)."
    }
    ]
}

/*
*   Function to render the dynamic fields accroding to the dropdown selection
*/
export const renderField = (field, isLast, errors, selectedValue, Field, ErrorMessage) => (
    <>
        <div className="form-group row" key={selectedValue + "-" + field.name}>
            <label htmlFor={field.name} className="col-form-label col-sm-2">{field.label}<i>*</i></label>
            <div className="col-sm-3">
                <Field type="number" className={`form-control ${errors[field.name] && 'is-invalid'}`} id={field.name} name={field.name} placeholder={field.placeholder} required />
                <ErrorMessage name={field.name} component="div" className="invalid-feedback d-block" />
            </div>
        </div>
        {isLast && <p> Product of Type <strong> {selectedValue} </strong> is selected, please provide <strong>{field.description}</strong> </p>}
    </>
)
