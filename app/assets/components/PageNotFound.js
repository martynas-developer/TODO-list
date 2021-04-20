import React from 'react';
import {Link} from "react-router-dom";

const PageNotFound = () => {
    return (
        <div className="container">
            <div className="row justify-content-center">
                <div className="col-12 text-center"><h2 className="block">Nothing here...</h2></div>
                <div className="col-12 text-center"><Link to="/">To the homepage</Link></div>
            </div>
        </div>
    );
}

export default PageNotFound