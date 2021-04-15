import React, {useEffect, useState} from 'react';
import useFetch from "../utils/useFetch";
import {Link, useHistory} from "react-router-dom";

const Create = () => {
    const [email, setEmail] = useState('afe@sdf.gfds')
    const [password, setPassword] = useState('testtest')
    const history = useHistory();
    const login = { email, password };
    const { executeFetch, isLoading, error, data } = useFetch(
        '/api/login',
        { method: 'POST', body: JSON.stringify(login)},
        { immediate: false }
    );

    useEffect(() => {
        if (data && data.token) {
            localStorage.setItem('token', data.token)
            history.push('/');
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
                {!isLoading && <button type="submit">login</button>}
                {isLoading && <button type="submit" disabled>loading...</button>}
            </form>
            <Link to={`/register`}>
                Don't have an account? Register
            </Link>
        </>
    );
}

export default Create;