import React from 'react';
import {Link} from "react-router-dom";

const PageNotFound = () => {
    return (
        <div>
            <h2>Nothing here...</h2>
            <Link to="/">To the homepage</Link>
        </div>
    );
}

export default PageNotFound