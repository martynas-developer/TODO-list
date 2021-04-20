import {useCallback, useEffect, useState} from 'react';
import {useHistory} from "react-router-dom";

const useFetch = (url, options, {immediate, useToken} = {immediate: true, useToken: true}) => {
    const [data, setData] = useState(null);
    const [isLoading, setIsLoading] = useState(false);
    const [error, setError] = useState(null);
    const history = useHistory();

    // if component is switched while data is still being fetched an error is thrown.
    // to avoid that AbortController is used
    const abortController = new AbortController();

    const executeFetch = useCallback(async () => {
        await fetch(url, {
            signal: abortController.signal,
            ...(useToken && { headers: { Authorization: `Bearer ${localStorage.getItem('token')}`}}),
            ...options
        }).then(async res => {
            if (res.ok) {
                return res.json();
            }
            if (res.status === 401) {
                history.push('/login')
            }
            await res.json().then((x) => {
                throw new Error(Object.values(x))
            })
        }).then(body => {
            setError(null);
            setData(body);
        }).catch(err => {
            if (err.name !== 'AbortError') {
                setError(err.message);
            }
        }).finally(() => {
            setIsLoading(false);
        })
    }, [url, options])

    useEffect(() => {
        if (immediate) {
            executeFetch(abortController)
        }
        return () => abortController.abort()
    }, [executeFetch, immediate])

    return { data, error, isLoading, executeFetch }
}

export default useFetch;
