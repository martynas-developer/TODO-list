import React, {useEffect, useState} from 'react';
import useFetch from "../utils/useFetch";
import {Link, useHistory} from "react-router-dom";

const Register = () => {
    const [email, setEmail] = useState('afe@sdf.gfdsd')
    const [password, setPassword] = useState('testtest')
    const [repeatPassword, setRepeatPassword] = useState('testtest')
    const history = useHistory();
    const register = {email: email, password: {password: password, confirm: repeatPassword}};

    const {executeFetch, isLoading, error, data} = useFetch(
        '/api/register',
        {method: 'POST', body: JSON.stringify(register)},
        {immediate: false}
    );

    useEffect(() => {
        if (data) {
            history.push('/login');
        }
    }, [data]);

    const handleSubmit = (e) => {
        e.preventDefault();
        executeFetch()
    }

    return (
        <>
            {error && <div>{error}</div>}
            <form onSubmit={handleSubmit}>
                <label htmlFor="email">Enter Email</label>
                <input type="email"
                       value={email}
                       onChange={(e) => setEmail(e.target.value)}
                />
                <label htmlFor="password">Enter Password</label>
                <input type="password"
                       value={password}
                       onChange={(e) => setPassword(e.target.value)}
                />
                <label htmlFor="repeatPassword">Repeat Password</label>
                <input type="password"
                       value={repeatPassword}
                       onChange={(e) => setRepeatPassword(e.target.value)}
                />
                {!isLoading && <button type="submit">Register</button>}
                {isLoading && <button type="submit" disabled>loading...</button>}
            </form>
            <Link to={`/login`}>
                Already have an account? Login
            </Link>
        </>
    );
}

export default Register;