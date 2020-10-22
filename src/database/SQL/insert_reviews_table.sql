INSERT INTO reviews (
    user_id,
    product_id,
    contents,
    result,
    rating,
    created_at,
    updated_at
) VALUES (
    1, 1, '面白かった', 1, 5.0, now(), now()
), (
    1, 2, 'まあまあ面白かった', 1, 4.5, now(), now()
), (
    1, 3, 'まあまあだった', 1, 4.0, now(), now()
), (
    1, 4, 'ふつう', 0, 3.0, now(), now()
), (
    1, 5, 'つまらなかった', 2, 2.0, now(), now()
);