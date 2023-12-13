  <div class="details">

                    <div class="header">
                        <h6>Details of the Request <span class="text-end float-end text-warning">Balance =
                                @moneyFormat($amountRemaining)</span></h6>
                    </div>

                    <form wire:submit.prevent="saveExpense({{ $request_data->id }})">
                        <div class="row">
                            <div class="col-md-2">
                                <label for="expenditure">Expenditure Name:</label>
                                <input type="text" class="form-control" id="expenditure" wire:model="expenditure">
                                @error('expenditure')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-3">
                                <label for="description">Description:</label>
                                <input type="text" id="description" required class="form-control"
                                    wire:model="description">
                                @error('description')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="quantity">Quantity</label>
                                <input type="number" step='any' required class="form-control" wire:model="quantity">
                                @error('quantity')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-2">
                                <label for="unit_cost">Unit Cost ({{ $request_data->currency->code ?? 'N/A' }}):</label>
                                <input type="number" required class="form-control" wire:model="unit_cost">
                                @error('unit_cost')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="amount">Total Cost ({{ $request_data->currency->code ?? 'N/A' }}):</label>
                                <input type="number" readonly max="{{ $amountRemaining }}" required class="form-control"
                                    wire:model="amount">
                                @error('amount')
                                    <div class="text-danger text-small">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-2 pt-3 text-end">
                                <button class="btn btn-primary" type="submit">Save Item</button>
                            </div>
                        </div>
                    </form>
                    <br>

                    <table class="b-top-row" style="border-collapse:collapse;" width="100%" cellspacing="0">
                        <tbody>
                            <tr style="mso-yfti-irow:0;mso-yfti-firstrow:yes;height:15.75pt">
                                <td class="btop t-bold" width="149" rowspan="2" valign="top">
                                    Description of expenditure
                                </td>
                                <td class="btop t-bold" width="189" rowspan="2" valign="top">
                                    More Details (IfAny)
                                </td>
                                <td class="btop t-bold" width="66" rowspan="2" valign="top">
                                    Qty
                                </td>
                                <td class="btop t-bold text-center" width="234" colspan="2" valign="top">
                                    Amount (Currency)
                                </td>
                            </tr>
                            <tr style="mso-yfti-irow:1;height:11.25pt">
                                <td class="btop t-bold" width="113" valign="top">
                                    Unit Cost ({{ $request_data->currency->code ?? 'N/A' }})
                                </td>
                                <td class="btop t-bold" width="121" valign="top">
                                    Amount ({{ $request_data->currency->code ?? 'N/A' }})
                                </td>
                            </tr>
                            @forelse ($items as $item)
                                <tr>
                                    <td class="btop" width="149">
                                        {{ $item->expenditure ?? 'N/A' }}
                                    </td>
                                    <td class="btop" width="189" valign="top">
                                        {{ $item->description ?? 'N/A' }}
                                    </td>
                                    <td class="btop text-end" width="66" valign="top">
                                        {{ $item->quantity ?? '0' }}
                                    </td>
                                    <td class="btop text-end" width="113">
                                        @moneyFormat($item->unit_cost)
                                    </td>
                                    <td class="btop text-end" width="121">
                                        @moneyFormat($item->amount)
                                        <a href="javascript:void(0)" wire:click="confirmDelete('{{ $item->id }}')"
                                            class="text-danger">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr class="btop">
                                    <td colspan="4" class="text-center text-danger">No entries yet</td>
                                </tr>
                            @endforelse

                            <tr>
                                <td class="btop t-bold" width="518" colspan="4" valign="top">
                                    Total
                                </td>
                                <td class="btop t-bold text-end">
                                    @moneyFormat($totalAmount)
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>