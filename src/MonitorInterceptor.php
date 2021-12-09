<?php

declare(strict_types=1);

namespace Pj8\SentryModule;

use Ray\Aop\MethodInvocation;

final class MonitorInterceptor implements MonitorInterceptorInteterface
{
    private SpanInterface $span;
    private SpanContextFactoryInterface $factory;

    public function __construct(SpanInterface $span, SpanContextFactoryInterface $factory)
    {
        $this->span = $span;
        $this->factory = $factory;
    }

    /**
     * {@inheritDoc}
     */
    public function invoke(MethodInvocation $invocation)
    {
        $spanContext = ($this->factory)($invocation);
        $this->span->start($spanContext);
        $result = $invocation->proceed();
        $this->span->finish();

        return $result;
    }
}
