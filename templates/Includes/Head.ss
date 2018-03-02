<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
    <title><% if $MetaTitle %>$MetaTitle<% else %>$Title<% end_if %></title>
    <% with $MetaDescription %>
        <% if $Me %>
            <meta name="description" content="$Me" />
        <% end_if %>
    <% end_with %>
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ffffff">
    <base href="/">
</head>