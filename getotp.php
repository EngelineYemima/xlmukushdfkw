 public function getOtp(Request $request)
    {
        $nomor = $request->nomor;
        $date = carbon::now()->format('Y-m-d\TH:i:s.uP');
        $uuid = Str::uuid()->toString();
        $key ="vT8tINqHaOxXbGE7eOWAhA==";

//       check tipe nomer xl
        $tipexl = Http::withHeaders([
            'Host' => 'api.myxl.xlaxiata.co.id',
            "x-request-id" => $uuid,
            "x-x-request-at" => $date,
            'x-api-key' => $key,
            'x-version-app' => '5.8.6',
            'Content-Type' => 'application/json',
        ])
            ->post('https://api.myxl.xlaxiata.co.id/infos/api/v1/auth/subscriber-info', [
                'lang' => 'en',
                'is_enterprise' => false,
                'msisdn' => $nomor,
            ]);

//      return $tipexl->getBody()->getContents();

        if ($tipexl['status'] == 'FAILED') {
            return response()->json([
                'status' => 'error',
                'message' => 'Nomor XL tidak ditemukan'
            ]);
        }

        //get auth step 1
        $auth = Http::withHeaders([
            'Host' => 'ciam-rajaampat.xl.co.id',
            'user-agent' => 'okhttp/4.3.1',
        ])
            ->post('https://ciam-rajaampat.xl.co.id/am/json/realms/xl/authenticate?authIndexType=service&authIndexValue=otp');

//       return $auth->getBody()->getContents();

        //ambil data authId
        $authId = $auth['authId'];

        //get auth step 2
            $reps4 = Http::withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'okhttp/4.3.1',
                'Host' => 'ciam-rajaampat.xl.co.id',
                'Content-Type' => 'application/json',
                ])
                ->post('https://ciam-rajaampat.xl.co.id/am/json/realms/xl/authenticate', [
                    'authId' => $authId,
                    'stage' => 'MSISDN',
                    'callbacks' => [
                        [
                            'type' => 'MetadataCallback',
                            'output' => [
                                [
                                    'name' => 'data',
                                    'value' => [
                                        'stage' => 'MSISDN',
                                    ],
                                ],
                            ],
                            '_id' => 0,
                        ],
                        [
                            'type' => 'NameCallback',
                            'output' => [
                                [
                                    'name' => 'prompt',
                                    'value' => 'MSISDN',
                                ],
                            ],
                            'input' => [
                                [
                                    'name' => 'IDToken2',
                                    'value' => $nomor
                                ],
                            ],
                            '_id' => 1,
                        ],
                        [
                            'type' => 'HiddenValueCallback',
                            'output' => [
                                [
                                    'name' => 'value',
                                    'value' => '',
                                ],
                                [
                                    'name' => 'id',
                                    'value' => 'Language',
                                ],
                            ],
                            'input' => [
                                [
                                    'name' => 'IDToken3',
                                    'value' => 'MYXLU_AND_LOGIN_EN',
                                ],
                            ],
                            '_id' => 2,
                        ],
                    ],
                ]);
//                return $reps4->getBody()->getContents();

                $authId2 = $reps4['authId'];

        //get auth step 3
        //
        $reps5 = Http::withHeaders([
            'Accept' => 'application/json',
            'User-Agent' => 'okhttp/4.3.1',
            'Host' => 'ciam-rajaampat.xl.co.id',
            'Content-Type' => 'application/json',
        ])
            ->post('https://ciam-rajaampat.xl.co.id/am/json/realms/xl/authenticate',
                [
                'authId' => $authId2,
                'stage' => 'DEVICE',
                'callbacks' => [
                    [
                        'type' => 'MetadataCallback',
                        'output' => [
                            [
                                'name' => 'data',
                                'value' => [
                                    'stage' => 'DEVICE'
                                ]
                            ]
                        ],
                        '_id' => 4
                    ],
                    [
                        'type' => 'HiddenValueCallback',
                        'output' => [
                            [
                                'name' => 'value',
                                'value' => 'Input Device Information'
                            ],
                            [
                                'name' => 'id',
                                'value' => 'DeviceInformation'
                            ]
                        ],
                        'input' => [
                            [
                                'name' => 'IDToken2',
                                'value' => 'dbac5ca67dd67e1b-bfe1b1262ce9a9462ce79545c1e6656395320898'
                            ]
                        ],
                        '_id' => 5
                    ]
                ]
            ]);

//                return $reps5->getBody()->getContents();

        $authId3 = $reps5['authId'];
        $subid =  $reps5['callbacks'][2]['output'][0]['value'];


        $data = [
            'authId' => $authId3,
            'stage' => 'VALIDATE',
            'callbacks' => [
                [
                    'type' => 'MetadataCallback',
                    'output' => [
                        [
                            'name' => 'data',
                            'value' => [
                                'stage' => 'VALIDATE'
                            ]
                        ]
                    ],
                    '_id' => 7
                ],
                [
                    'type' => 'ConfirmationCallback',
                    'output' => [
                        [
                            'name' => 'prompt',
                            'value' => 'Validate'
                        ],
                        [
                            'name' => 'messageType',
                            'value' => 0
                        ],
                        [
                            'name' => 'options',
                            'value' => [
                                '0 = NO',
                                '1 = YES'
                            ]
                        ],
                        [
                            'name' => 'optionType',
                            'value' => -1
                        ],
                        [
                            'name' => 'defaultOption',
                            'value' => 0
                        ]
                    ],
                    'input' => [
                        [
                            'name' => 'IDToken2',
                            'value' => 1
                        ]
                    ],
                    '_id' => 8
                ],
                [
                    'type' => 'TextOutputCallback',
                    'output' => [
                        [
                            'name' => 'message',
                            'value' => $subid
                        ],
                        [
                            'name' => 'messageType',
                            'value' => '0'
                        ]
                    ],
                    '_id' => 9
                ]
            ]
        ];

        try{
            $reps6 = Http::withHeaders([
                'Accept' => 'application/json',
                'User-Agent' => 'okhttp/4.3.1',
                'Host' => 'ciam-rajaampat.xl.co.id',
                'Content-Type' => 'application/json',
            ])
                ->post('https://ciam-rajaampat.xl.co.id/am/json/realms/xl/authenticate',
                    $data
                );

//                            return $reps6->getBody()->getContents();
            $authId3 = $reps6['authId'];
            return Response()->json([
                'status' => true,
                'auth_id' => $authId3,
                'message' => 'Berhasil mengirim OTP'
            ]);


        }catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ]);

        }

    }
